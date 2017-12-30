<?php

namespace Naviapps\Bundle\CatalogBundle\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Naviapps\Bundle\CatalogBundle\Entity\Category;
use Naviapps\Component\Repository\ServiceEntityRepository;

class CategoryRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }
}
