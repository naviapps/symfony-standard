<?php

namespace Naviapps\Bundle\SalesBundle\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Naviapps\Bundle\SalesBundle\Entity\OrderStatus;
use Naviapps\Component\Repository\ServiceEntityRepository;

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
