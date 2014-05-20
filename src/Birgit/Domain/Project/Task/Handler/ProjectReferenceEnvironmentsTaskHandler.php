<?php

namespace Birgit\Domain\Project\Task\Handler;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Task\Handler\TaskHandler;
use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Domain\Project\ProjectManager;
use Birgit\Domain\Project\ProjectEvents;
use Birgit\Domain\Project\Event\ProjectStatusEvent;
use Birgit\Model\Task\Task;
use Birgit\Model\Project\ProjectStatus;
use Birgit\Component\Parameters\Parameters;
use Birgit\Domain\Task\TaskManager;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;

/**
 * Project reference Environments Task handler
 */
class ProjectReferenceEnvironmentsTaskHandler extends TaskHandler
{
    protected $eventDispatcher;
    protected $projectManager;
    protected $taskManager;

    public function __construct(EventDispatcherInterface $eventDispatcher, ProjectManager $projectManager, TaskManager $taskManager)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->projectManager  = $projectManager;
        $this->taskManager     = $taskManager;
    }

    public function getType()
    {
        return 'project_reference_environments';
    }

    public function run(Task $task, TaskQueueContext $context)
    {
        if (!$context instanceof ProjectReferenceTaskQueueContextInterface) {
            return;
        }

        // Get project reference
        $projectReference = $context->getProjectReference();

        // Log
        $context->getLogger()->notice(sprintf('Task Handler: Project Reference Environments "%s" "%s"', $projectReference->getProject()->getName(), $projectReference->getName()));

        foreach ($projectReference->getProject()->getEnvironments() as $projectEnvironment) {
        	var_dump($projectEnvironment->getName());
        }
    }
}
