<?php

namespace Naviapps\Component\Repository;

use Doctrine\ORM\EntityRepository as BaseEntityRepository;

class EntityRepository extends BaseEntityRepository
{
    /**
     * @param mixed $args
     * @return mixed
     */
    public function build(...$args)
    {
        return new $this->_entityName(...$args);
    }
}
