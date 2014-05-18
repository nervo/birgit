<?php

namespace Birgit\Bundle\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;

/**
 * Entity Repository
 */
abstract class EntityRepository extends DoctrineEntityRepository
{
    public function create()
    {
        $class = $this->getClassName();

        return new $class();
    }
}
