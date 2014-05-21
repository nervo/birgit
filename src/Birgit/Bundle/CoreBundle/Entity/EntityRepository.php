<?php

namespace Birgit\Bundle\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;
use Birgit\Model\ModelRepositoryInterface;

/**
 * Entity Repository
 */
abstract class EntityRepository extends DoctrineEntityRepository implements ModelRepositoryInterface
{
    public function all()
    {
        return $this->findAll();
    }

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
