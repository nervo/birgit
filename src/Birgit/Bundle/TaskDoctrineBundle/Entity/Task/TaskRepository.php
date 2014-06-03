<?php

namespace Birgit\Bundle\TaskDoctrineBundle\Entity\Task;

use Birgit\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Component\Task\Model\Task\TaskRepositoryInterface;
use Birgit\Component\Handler\HandlerDefinition;
use Birgit\Domain\Exception\Model\ModelNotFoundException;

/**
 * Task Repository
 */
class TaskRepository extends EntityRepository implements TaskRepositoryInterface
{
    public function create(HandlerDefinition $handlerDefinition)
    {
        $task = $this->createEntity();

        $task
            ->setHandlerDefinition($handlerDefinition);

        return $task;
    }

    public function save(Task $task)
    {
        $this->saveEntity($task);
    }

    public function get($id)
    {
        $task = $this->findOneById($id);

        if (!$task) {
            throw new ModelNotFoundException();
        }

        return $task;
    }

    public function delete(Task $task)
    {
        $this->deleteEntity($task);
    }
}
