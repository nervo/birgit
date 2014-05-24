<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Task\Queue;

use Birgit\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Model\Task\Queue\TaskQueueRepositoryInterface;
use Birgit\Domain\Handler\HandlerDefinition;

/**
 * Task queue Repository
 */
class TaskQueueRepository extends EntityRepository implements TaskQueueRepositoryInterface
{
    public function create(HandlerDefinition $handlerDefinition)
    {
        $taskQueue = $this->createEntity();
        
        $taskQueue
            ->setHandlerDefinition($handlerDefinition);
        
        return $taskQueue;
    }
}
