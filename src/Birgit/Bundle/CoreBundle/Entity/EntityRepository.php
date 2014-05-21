<?php

namespace Birgit\Bundle\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;

/**
 * Entity Repository
 */
abstract class EntityRepository extends DoctrineEntityRepository
{
    protected function createEntity()
    {
        $className = $this->getClassName();

        return new $className();
    }

    protected function saveEntity($entity)
    {
        $entityManager = $this->getEntityManager();
        
        $entityManager->persist($entity);
        $entityManager->flush($entity);
    }
}
