<?php

namespace Birgit\Component\Task\Bundle\DoctrineBundle\Entity\Task\Queue;

use Birgit\Component\Task\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Component\Task\Model\Task\Queue\TaskQueueRepositoryInterface;
use Birgit\Component\Type\TypeDefinition;
use Birgit\Component\Task\Exception\NotFoundException;
use Birgit\Component\Task\Model\Task\Queue\TaskQueueRepositoryIterator;

/**
 * Task queue Repository
 */
class TaskQueueRepository extends EntityRepository implements TaskQueueRepositoryInterface
{
    public function create(TypeDefinition $typeDefinition)
    {
        $taskQueue = $this->createEntity();

        $taskQueue
            ->setTypeDefinition($typeDefinition);

        return $taskQueue;
    }

    public function save(TaskQueue $taskQueue)
    {
        $this->saveEntity($taskQueue);
    }

    public function get($id)
    {
        $taskQueue = $this->findOneById($id);

        if (!$taskQueue) {
            throw new NotFoundException();
        }

        return $taskQueue;
    }

    public function delete(TaskQueue $taskQueue)
    {
        $this->deleteEntity($taskQueue);
    }

    public function findFirstOneWithIdNotIn(array $ids)
    {
        $queryBuilder = $this->createQueryBuilder('taskQueue')
            ->setMaxResults(1);

        if ($ids) {
            $queryBuilder
                ->where('taskQueue.id NOT IN (:ids)')
                ->setParameter('ids', $ids);
        }

        return $queryBuilder
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getIterator()
    {
        return new TaskQueueRepositoryIterator($this);
    }
}
