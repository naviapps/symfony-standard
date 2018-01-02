<?php

namespace Naviapps\Bundle\CatalogBundle\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Naviapps\Component\Repository\ServiceEntityRepository;

class CategoryRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     * @param string $categoryClass
     */
    public function __construct(ManagerRegistry $registry, string $categoryClass)
    {
        parent::__construct($registry, $categoryClass);
    }
}
