<?php

namespace Birgit\Domain\Project\Task\Handler;

use Birgit\Domain\Task\Handler\TaskHandler;
use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Model\Task\Task;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Model\ModelManagerInterface;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;
use Birgit\Component\Parameters\Parameters;
use Birgit\Domain\Handler\HandlerDefinition;
use Birgit\Domain\Exception\Context\ContextException;

/**
 * Project reference Environments Task handler
 */
class ProjectReferenceEnvironmentsTaskHandler extends TaskHandler
{
    protected $modelManager;
    protected $handlerManager;

    public function __construct(
        ModelManagerInterface $modelManager,
        HandlerManager $handlerManager
    ) {
        $this->modelManager   = $modelManager;
        $this->handlerManager = $handlerManager;
    }

    public function getType()
    {
        return 'project_reference_environments';
    }

    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof ProjectReferenceTaskQueueContextInterface) {
            throw new ContextException();
        }

        // Get project reference
        $projectReference = $context->getProjectReference();

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
            } else if ($projectEnvironment->matchReference($projectReference)) {
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
