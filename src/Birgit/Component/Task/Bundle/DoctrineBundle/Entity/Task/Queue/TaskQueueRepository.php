<?php

namespace Birgit\Component\Task\Bundle\DoctrineBundle\Entity\Task\Queue;

use Birgit\Component\Task\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Component\Task\Model\Task\Queue\TaskQueueRepositoryInterface;
use Birgit\Component\Type\TypeDefinition;
use Birgit\Component\Task\Exception\NotFoundException;
use Birgit\Component\Task\Bundle\DoctrineBundle\Entity\Task\Task;
use Birgit\Component\Task\Event\TaskEvent;
use Birgit\Component\Task\Queue\TaskQueueEvents;
use Birgit\Component\Task\Queue\Event\TaskQueueEvent;

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

    /**
     * Find first one with id not in ids
     *
     * @param array $ids
     *
     * @return TaskQueue|null
     */
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
}
