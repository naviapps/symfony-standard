<?php

namespace Naviapps\Bundle\DirectoryBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Naviapps\Bundle\DirectoryBundle\Entity\Postcode;

class PostcodeRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Postcode::class);
    }
}
