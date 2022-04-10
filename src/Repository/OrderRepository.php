<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\User;
use App\Interfaces\ConstantInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }


    public function getOrderList(
        ?User $user = null,
        int $offset = ConstantInterface::PAGINATION_DEFAULT_OFFSET,
        int $limit = ConstantInterface::PAGINATION_DEFAULT_LIMIT
    ): array
    {
        $qb = $this->createQueryBuilder('o')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        if ($user) {
            $qb->join('o.user', 'u');
        }

        return $qb->getQuery()->getResult();
    }
}
