<?php

namespace Birgit\Domain\Project\Task\Handler;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Task\Handler\TaskHandler;
use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Model\Task\Task;
use Birgit\Domain\Task\TaskManager;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;
use Birgit\Component\Parameters\Parameters;

/**
 * Project reference Environments Task handler
 */
class ProjectReferenceEnvironmentsTaskHandler extends TaskHandler
{
    protected $taskManager;
    protected $eventDispatcher;

    public function __construct(
        TaskManager $taskManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->taskManager     = $taskManager;
        $this->eventDispatcher = $eventDispatcher;
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

        // Find hosts to delete
        foreach ($projectReference->getHosts() as $host) {
            if (!$host->getProjectEnvironment()->matchReference($projectReference)) {
                $taskQueue = $this->taskManager
                    ->createTaskQueue(
                        'host_delete',
                        new Parameters(array(
                            'project_name'             => $projectReference->getProject()->getName(),
                            'project_reference_name'   => $projectReference->getName(),
                            'project_environment_name' => $host->getProjectEnvironment()->getName()
                        ))
                    );

                $this->taskManager
                    ->getTaskQueueHandler($taskQueue)
                        ->run($taskQueue);
            }
        }

        // Find hosts
        foreach ($projectReference->getProject()->getEnvironments() as $projectEnvironment) {
            $hostFound = false;
            foreach ($projectReference->getHosts() as $host) {
                if ($host->getProjectEnvironment() === $projectEnvironment) {
                    $hostFound = true;
                    break;
                }
            }
            
            if ($hostFound) {
                $taskQueue = $this->taskManager
                    ->createTaskQueue(
                        'host',
                        new Parameters(array(
                            'project_name'             => $projectReference->getProject()->getName(),
                            'project_reference_name'   => $projectReference->getName(),
                            'project_environment_name' => $projectEnvironment->getName()
                        ))
                    );

                $this->taskManager
                    ->getTaskQueueHandler($taskQueue)
                        ->run($taskQueue);                
            } else {
                $taskQueue = $this->taskManager
                    ->createTaskQueue(
                        'host_create',
                        new Parameters(array(
                            'project_name'             => $projectReference->getProject()->getName(),
                            'project_reference_name'   => $projectReference->getName(),
                            'project_environment_name' => $projectEnvironment->getName()
                        ))
                    );

                $this->taskManager
                    ->getTaskQueueHandler($taskQueue)
                        ->run($taskQueue);
            }
        }
    }
}
