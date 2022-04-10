<?php

namespace App\Traits;

use App\Service\User\UserRegisterService;
use Doctrine\ORM\EntityManagerInterface;


trait EntityManagerAwareTrait
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @required
     *
     * @param EntityManagerInterface $entityManager
     * @return EntityManagerAwareTrait|UserRegisterService
     */
    public function setEntityManager(EntityManagerInterface $entityManager): self
    {
        $this->entityManager = $entityManager;

        return $this;
    }
}
