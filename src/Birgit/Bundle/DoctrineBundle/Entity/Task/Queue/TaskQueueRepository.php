<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Task\Queue;

use Birgit\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Model\Task\Queue\TaskQueueRepositoryInterface;
use Birgit\Component\Handler\HandlerDefinition;
use Birgit\Domain\Exception\Model\ModelNotFoundException;

/**
 * Task queue Repository
 */
class TaskQueueRepository extends EntityRepository implements TaskQueueRepositoryInterface, \IteratorAggregate
{
    public function create(HandlerDefinition $handlerDefinition)
    {
        $taskQueue = $this->createEntity();

        $taskQueue
            ->setHandlerDefinition($handlerDefinition);

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
            throw new ModelNotFoundException();
        }

        return $taskQueue;
    }

    public function delete(TaskQueue $taskQueue)
    {
        $this->deleteEntity($taskQueue);
    }

    public function getIterator()
    {
        $this->getEntityManager()->clear();

        $query = $this
            ->createQueryBuilder('taskQueue')
            ->leftJoin('taskQueue.tasks', 'taskQueueTasks')
            ->getQuery();

        return new \ArrayIterator(
            $query->getResult()
        );
    }
}
