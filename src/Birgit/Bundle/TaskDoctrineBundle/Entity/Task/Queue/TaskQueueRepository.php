<?php

namespace Birgit\Bundle\TaskDoctrineBundle\Entity\Task\Queue;

use Birgit\Bundle\TaskDoctrineBundle\Entity\EntityRepository;
use Birgit\Component\Task\Model\Task\Queue\TaskQueueRepositoryInterface;
use Birgit\Component\Handler\HandlerDefinition;
use Birgit\Component\Task\Exception\NotFoundException;

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
            throw new NotFoundException();
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
