<?php

namespace Naviapps\Bundle\CmsBundle\Repository;

use Naviapps\Bundle\CmsBundle\Entity\Block;
use Doctrine\Common\Persistence\ManagerRegistry;
use Naviapps\Component\Repository\ServiceEntityRepository;

class BlockRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Block::class);
    }
}
