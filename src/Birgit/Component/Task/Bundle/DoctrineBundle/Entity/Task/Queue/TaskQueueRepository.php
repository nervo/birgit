<?php

namespace Birgit\Component\Task\Bundle\DoctrineBundle\Entity\Task\Queue;

use Birgit\Component\Task\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Component\Task\Model\Task\Queue\TaskQueueRepositoryInterface;
use Birgit\Component\Type\TypeDefinition;
use Birgit\Component\Task\Exception\NotFoundException;
use Birgit\Component\Task\Model\Task\Queue\TaskQueueRepositoryIterator;
use Birgit\Component\Task\Bundle\DoctrineBundle\Entity\Task\Task;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Birgit\Component\Task\TaskEvents;
use Birgit\Component\Task\Event\TaskEvent;
use Birgit\Component\Task\Queue\TaskQueueEvents;
use Birgit\Component\Task\Queue\Event\TaskQueueEvent;

/**
 * Task queue Repository
 */
class TaskQueueRepository extends EntityRepository implements TaskQueueRepositoryInterface, EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            TaskEvents::RUN_END      => 'onTaskRunEnd',
            TaskQueueEvents::RUN_END => 'onTaskQueueRunEnd'
        );
    }

    public function onTaskRunEnd(TaskEvent $event)
    {
        // Get task queue
        $taskQueue = $event->getTask()->getQueue();

        // Save
        $this->save($taskQueue);
    }

    public function onTaskQueueRunEnd(TaskQueueEvent $event)
    {
        // Get task queue
        $taskQueue = $event->getTaskQueue();

        // Save
        $this->save($taskQueue);
    }

    public function create(TypeDefinition $typeDefinition)
    {
        $taskQueue = $this->createEntity();

        $taskQueue
            ->setTypeDefinition($typeDefinition);

        return $taskQueue;
    }

    public function addTaskQueueTask(TaskQueue $taskQueue, Task $task)
    {
        $taskQueue
            ->addTask($task);

        $this->save($taskQueue);

        // Dispatch event
        $this->eventDispatcher
            ->dispatch(
                TaskQueueEvents::TASK_ADD,
                new TaskEvent($task)
            );
    }

    public function save(TaskQueue $taskQueue)
    {
        $isNew = $taskQueue->isNew();

        $this->saveEntity($taskQueue);

        // Dispatch event
        $this->eventDispatcher
            ->dispatch(
                $isNew ? TaskQueueEvents::CREATE : TaskQueueEvents::UPDATE,
                new TaskQueueEvent($taskQueue)
            );
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
