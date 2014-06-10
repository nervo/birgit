<?php

namespace Birgit\Component\Event\Bundle\DoctrineBundle\Entity;

use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;

use Birgit\Component\Event\Model\ModelRepositoryInterface;

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
        $entityManager->flush();
    }

    protected function refreshEntity($entity)
    {
        $entityManager = $this->getEntityManager();

        $entityManager->refresh($entity);
    }

    protected function deleteEntity($entity)
    {
        $entityManager = $this->getEntityManager();

        $entityManager->remove($entity);
        $entityManager->flush();
    }
}
