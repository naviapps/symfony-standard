<?php

namespace Naviapps\Bundle\CatalogBundle\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Naviapps\Bundle\FrameworkBundle\Repository\ServiceEntityRepository;

class ProductRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     * @param string $productClass
     */
    public function __construct(ManagerRegistry $registry, string $productClass)
    {
        parent::__construct($registry, $productClass);
    }
}
