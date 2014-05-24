<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Task;

use Birgit\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Model\Task\TaskRepositoryInterface;
use Birgit\Domain\Handler\HandlerDefinition;

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
}
