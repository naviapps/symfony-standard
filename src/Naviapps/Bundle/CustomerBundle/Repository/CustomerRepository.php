<?php

namespace Naviapps\Bundle\CustomerBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CustomerRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     * @param string $customerClass
     */
    public function __construct(ManagerRegistry $registry, string $customerClass)
    {
        parent::__construct($registry, $customerClass);
    }
}
