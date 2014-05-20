<?php

namespace Birgit\Domain\Project\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Domain\Project\ProjectManager;
use Birgit\Domain\Task\TaskManager;

/**
 * Project reference Task queue Handler
 */
class ProjectReferenceTaskQueueHandler extends TaskQueueHandler
{
    protected $projectManager;

    public function __construct(ProjectManager $projectManager, TaskManager $taskManager, EventDispatcherInterface $eventDispatcher, LoggerInterface $logger)
    {
        $this->projectManager = $projectManager;

        parent::__construct($taskManager, $eventDispatcher, $logger);
    }

    public function getType()
    {
        return 'project_reference';
    }

    protected function preRun(TaskQueue $taskQueue)
    {
        // Get project name
        $projectName = $taskQueue->getParameters()->get('project_name');

        // Get project
        $project = $this->projectManager
            ->findProject($projectName);

        // Get project reference name
        $projectReferenceName = $taskQueue->getParameters()->get('project_reference_name');

        // Get project reference
        $projectReference = $this->projectManager
            ->findProjectReference($project, $projectReferenceName);

        return new ProjectReferenceTaskQueueContext(
            $projectReference,
            $taskQueue,
            $this->logger
        );
    }
}
