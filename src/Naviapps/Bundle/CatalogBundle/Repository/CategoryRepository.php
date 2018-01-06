<?php

namespace Naviapps\Bundle\CatalogBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Gedmo\Tree\Entity\Repository\MaterializedPathRepository;

class CategoryRepository extends MaterializedPathRepository implements ServiceEntityRepositoryInterface
{
    /**
     * @param ManagerRegistry $registry
     * @param string $categoryClass
     */
    public function __construct(ManagerRegistry $registry, string $categoryClass)
    {
        $manager = $registry->getManagerForClass($categoryClass);

        parent::__construct($manager, $manager->getClassMetadata($categoryClass));
    }

    /**
     * @param mixed $args
     * @return mixed
     */
    public function build(...$args)
    {
        return new $this->_entityName(...$args);
    }
}
