<?php

namespace Birgit\Domain\Project\Task\Handler;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Task\Handler\TaskHandler;
use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Model\Task\Task;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Model\ModelManagerInterface;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;
use Birgit\Component\Parameters\Parameters;
use Birgit\Domain\Handler\HandlerDefinition;

/**
 * Project reference Environments Task handler
 */
class ProjectReferenceEnvironmentsTaskHandler extends TaskHandler
{
    protected $handlerManager;
    protected $modelManager;
    protected $eventDispatcher;

    public function __construct(
        HandlerManager $handlerManager,
        ModelManagerInterface $modelManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->handlerManager = $handlerManager;
        $this->modelManager = $modelManager;
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
                $taskQueue = $this->modelManager
                    ->getTaskQueueRepository()
                    ->create(
                        new HandlerDefinition(
                            'host_delete',
                            new Parameters(array(
                                'project_name'             => $projectReference->getProject()->getName(),
                                'project_reference_name'   => $projectReference->getName(),
                                'project_environment_name' => $host->getProjectEnvironment()->getName()
                            ))
                        )
                    );

                $this->handlerManager
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
                $taskQueue = $this->modelManager
                    ->getTaskQueueRepository()
                    ->create(
                        new HandlerDefinition(
                            'host',
                            new Parameters(array(
                                'project_name'             => $projectReference->getProject()->getName(),
                                'project_reference_name'   => $projectReference->getName(),
                                'project_environment_name' => $projectEnvironment->getName()
                            ))
                        )
                    );

                $this->handlerManager
                    ->getTaskQueueHandler($taskQueue)
                        ->run($taskQueue);                
            } else {
                $taskQueue = $this->modelManager
                    ->getTaskQueueRepository()
                    ->create(
                        new HandlerDefinition(
                            'host_create',
                            new Parameters(array(
                                'project_name'             => $projectReference->getProject()->getName(),
                                'project_reference_name'   => $projectReference->getName(),
                                'project_environment_name' => $projectEnvironment->getName()
                            ))
                        )
                    );

                $this->handlerManager
                    ->getTaskQueueHandler($taskQueue)
                        ->run($taskQueue);
            }
        }
    }
}
