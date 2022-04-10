<?php

namespace App\Service\Order;

use App\Entity\Order;
use App\Entity\User;
use App\Interfaces\Exception\ExceptionMessageInterface;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderShowService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    private OrderRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->repository = $entityManager->getRepository(Order::class);
    }

    /**
     * @param string $orderCode
     * @param User $user
     * @return int[]
     * @throws NotFoundHttpException
     */
    public function getOrderByCode(string $orderCode, User $user): array
    {
        $order = $this->repository->findBy([
            'user' => $user,
            'orderCode' => $orderCode
        ]);

        return $order ?: throw new NotFoundHttpException(ExceptionMessageInterface::ORDER_NOT_FOUND);
    }
}
