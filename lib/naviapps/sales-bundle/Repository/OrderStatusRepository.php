<?php

namespace Naviapps\Bundle\SalesBundle\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Naviapps\Bundle\FrameworkBundle\Repository\ServiceEntityRepository;
use Naviapps\Bundle\SalesBundle\Entity\OrderStatus;

class OrderStatusRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderStatus::class);
    }
}
