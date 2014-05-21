<?php

namespace Birgit\Domain\Project\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContext;
use Birgit\Model\ModelManagerInterface;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Domain\Task\TaskManager;

/**
 * Project reference Task queue Handler
 */
class ProjectReferenceTaskQueueHandler extends TaskQueueHandler
{
    protected $modelManager;

    public function __construct(
        TaskManager $taskManager,
        ModelManagerInterface $modelManager,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->modelManager = $modelManager;

        parent::__construct($taskManager, $eventDispatcher, $logger);
    }

    public function getType()
    {
        return 'project_reference';
    }

    protected function preRun(TaskQueue $taskQueue)
    {
        // Get project
        $project = $this->modelManager
            ->getProjectRepository()
            ->get(
                $taskQueue->getParameters()->get('project_name')
            );

        // Get project reference
        $projectReference = $this->modelManager
            ->getProjectReferenceRepository()
            ->get(
                $taskQueue->getParameters()->get('project_reference_name'),
                $project
            );

        return new ProjectReferenceTaskQueueContext(
            $projectReference,
            $taskQueue,
            $this->logger
        );
    }
}
