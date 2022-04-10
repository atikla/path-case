<?php

namespace App\Service\Order;

use App\Entity\Order;
use App\Entity\User;
use App\Exception\Validation\ValidationException;
use App\Interfaces\Exception\ExceptionMessageInterface;
use App\Service\Validation\ValidationService;
use App\Traits\EntityManagerAwareTrait;
use DateTime;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrderUpdateService
{
    use EntityManagerAwareTrait;

    /**
     * @var Order|null $order
     */
    private ?Order $order = null;

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
        $this->validationService = $validationService;
        $this->user = $tokenStorage->getToken()->getUser();
    }

    /**
     * @param string $orderCode
     * @param User $user
     * @return Order
     */
    public function getOrderByCode(string $orderCode, User $user): Order
    {
        return $this->getEntityManager()->getRepository(Order::class)->findOneBy([
                'user' => $user,
                'orderCode' => $orderCode
            ])
            ?: throw new NotFoundHttpException(ExceptionMessageInterface::ORDER_NOT_FOUND);
    }

    /**
     * @param array $requestBody
     * @return OrderUpdateService
     * @throws ValidationException|Exception
     */
    public function validate(array $requestBody): self
    {
        if ($this->order->getShippingDate() !== NULL) {
            throw new ValidationException(message: ExceptionMessageInterface::ORDER_CAN_NOT_UPDATE);
        }

        $this->order
            ->setAddress($requestBody['address'])
            ->setShippingDate(!isset($requestBody['shippingDate']) ? null : new DateTime($requestBody['shippingDate']));

        $this->validationService->validate($this->order);

        return $this;
    }

    /**
     * @return Order
     */
    public function update(): Order
    {
        $this->getEntityManager()->persist($this->order);
        $this->getEntityManager()->flush();
        $this->getEntityManager()->refresh($this->order);

        return $this->order;
    }

    /**
     * @param Order|null $order
     * @return OrderUpdateService
     */
    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }
}
