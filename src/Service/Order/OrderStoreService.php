<?php

namespace App\Service\Order;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use App\Exception\Validation\ValidationException;
use App\Interfaces\Exception\ExceptionMessageInterface;
use App\Service\Validation\ValidationService;
use App\Traits\EntityManagerAwareTrait;
use DateTime;
use Exception;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrderStoreService
{
    use EntityManagerAwareTrait;

    /**
     * @var Order $order
     */
    private Order $order;

    /**
     * @var ValidationService $validationService
     */
    private ValidationService $validationService;

    /**
     * @var User $user
     */
    private User $user;

    /**
     * @param ValidationService $validationService
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(ValidationService $validationService, TokenStorageInterface $tokenStorage)
    {
        $this->order = new Order();
        $this->validationService = $validationService;
        $this->user = $tokenStorage->getToken()->getUser();
    }

    /**
     * @param array $requestBody
     * @return OrderStoreService
     * @throws ValidationException|Exception
     */
    public function validate(array $requestBody): self
    {
        $this->order
            ->setOrderCode($requestBody['orderCode'])
            ->setQuantity($requestBody['quantity'])
            ->setAddress($requestBody['address'])
            ->setShippingDate(!isset($requestBody['shippingDate']) ? null : new DateTime($requestBody['shippingDate']))
            ->setUser($this->user);

        $this->validationService->validate($this->order);

        /** @var Product $product */
        $product = $this->getEntityManager()->getRepository(Product::class)->find($requestBody['productId']);

        if (!$product) {
            throw new ValidationException(ExceptionMessageInterface::PRODUCT_IS_NOT_EXIST);
        }

        if ($this->order->getQuantity() > $product->getStock()) {
            throw new ValidationException(ExceptionMessageInterface::PRODUCT_DONT_HAVE_ENOUGH_STOCK);
        }

        $this->order->setProduct($product);

        return $this;
    }

    /**
     * @return Order
     */
    public function store(): Order
    {
        $product = $this->order->getProduct();
        $product->setStock($product->getStock() - $this->order->getQuantity());

        $this->order->setAmount($product->getPrice() * $this->order->getQuantity());

        $this->getEntityManager()->persist($this->order);
        $this->getEntityManager()->persist($product);

        $this->getEntityManager()->flush();

        $this->getEntityManager()->refresh($this->order);

        return $this->order;
    }
}
