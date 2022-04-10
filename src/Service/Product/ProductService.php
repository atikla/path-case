<?php

namespace App\Service\Product;

use App\Entity\Product;
use App\Interfaces\ConstantInterface;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    private ProductRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->repository = $entityManager->getRepository(Product::class);
    }

    /**
     * @param int $page
     * @return int[]
     */
    public function getProductList(int $page = 1): array
    {
        $offset  = ($page * ConstantInterface::PAGINATION_DEFAULT_LIMIT) - ConstantInterface::PAGINATION_DEFAULT_LIMIT;

        return $this->repository->getProductList(offset: $offset);
    }
}
