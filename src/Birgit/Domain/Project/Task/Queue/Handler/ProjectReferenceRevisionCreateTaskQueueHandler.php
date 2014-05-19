<?php

namespace Birgit\Domain\Project\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Project\ProjectManager;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceRevisionTaskQueueContext;
use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Task\TaskManager;
use Birgit\Model\Task\Queue\TaskQueue;

class ProjectReferenceRevisionCreateTaskQueueHandler extends TaskQueueHandler
{
    protected $projectManager;

    public function __construct(ProjectManager $projectManager, TaskManager $taskManager, EventDispatcherInterface $eventDispatcher, LoggerInterface $logger)
    {
        $this->projectManager = $projectManager;

        parent::__construct($taskManager, $eventDispatcher, $logger);
    }

    public function getType()
    {
        return 'project_reference_revision_create';
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

        $projectReferenceRevision = $this->projectManager
            ->createProjectReferenceRevision(
                $projectReference,
                $taskQueue->getParameters()->get('project_reference_revision_name')
            );

        $this->projectManager
            ->saveProjectReferenceRevision($projectReferenceRevision);

        return new ProjectReferenceRevisionTaskQueueContext(
            $projectReferenceRevision,
            $taskQueue,
            $this->logger
        );
    }
}
