<?php

namespace Birgit\Component\Repository\Reference\Task;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Doctrine\Common\Persistence\ManagerRegistry;

use Birgit\Component\Exception\Exception;
use Birgit\Component\Task\Task;
use Birgit\Component\Task\TaskContext;
use Birgit\Component\Task\TaskParameters;

/**
 * Repository reference Create Task
 */
class RepositoryReferenceCreateTask extends Task
{
    protected $doctrineManagerRegistry;

    protected $eventDispatcher;

    public function __construct(ManagerRegistry $doctrineManagerRegistry, EventDispatcherInterface $eventDispatcher)
    {
        $this->doctrineManagerRegistry = $doctrineManagerRegistry;

        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(TaskContext $context, TaskParameters $parameters = null)
    {
    	if (!$parameters instanceof RepositoryReferenceCreateTaskParameters) {
    		throw new Exception();
    	}

        // Log
        $context->getLogger()->notice('Task: Repository Reference Create');
    }
}
