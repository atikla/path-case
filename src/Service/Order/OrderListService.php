<?php

namespace App\Service\Order;

use App\Entity\Order;
use App\Entity\User;
use App\Interfaces\ConstantInterface;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderListService
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
     * @param int $page
     * @param User|null $user
     * @return int[]
     */
    public function getOrderList(int $page = 1, ?User $user = null): array
    {
        $offset  = ($page * ConstantInterface::PAGINATION_DEFAULT_LIMIT) - ConstantInterface::PAGINATION_DEFAULT_LIMIT;

        return $this->repository->getOrderList(user: $user, offset: $offset);
    }
}
