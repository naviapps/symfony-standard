<?php

namespace Naviapps\Bundle\SalesBundle\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Naviapps\Bundle\FrameworkBundle\Repository\ServiceEntityRepository;

class OrderRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     * @param string $orderClass
     */
    public function __construct(ManagerRegistry $registry, string $orderClass)
    {
        parent::__construct($registry, $orderClass);
    }
}
