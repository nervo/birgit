<?php

namespace Birgit\Component\Task\Bundle\DoctrineBundle\Entity\Task;

use Birgit\Component\Task\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Component\Task\Model\Task\TaskRepositoryInterface;
use Birgit\Component\Type\TypeDefinition;
use Birgit\Component\Task\Exception\NotFoundException;

/**
 * Task Repository
 */
class TaskRepository extends EntityRepository implements TaskRepositoryInterface
{
    public function create(TypeDefinition $typeDefinition)
    {
        $task = $this->createEntity();

        $task
            ->setTypeDefinition($typeDefinition);

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
            throw new NotFoundException();
        }

        return $task;
    }

    public function delete(Task $task)
    {
        $this->deleteEntity($task);
    }
}
