<?php

namespace Birgit\Domain\Task\Handler\Host;

use Birgit\Component\Task\Handler\TaskHandler;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Model\Task\Task;
use Birgit\Domain\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;
use Birgit\Component\Context\Exception\ContextException;

/**
 * Host - Create Task Handler
 */
class HostCreateTaskHandler extends TaskHandler
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'host_create';
    }

    /**
     * {@inheritdoc}
     */
    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof ProjectReferenceTaskQueueContextInterface) {
            throw new ContextException();
        }

        // Get project reference
        $projectReference = $context->getProjectReference();

        // Get project environment
        $projectEnvironment = $this->modelManager
            ->getProjectEnvironmentRepository()
            ->get(
                $task->getHandlerDefinition()->getParameters()->get('project_environment_name'),
                $projectReference->getProject()
            );

        // Create host
        $host = $this->modelManager
            ->getHostRepository()
            ->create(
                $projectReference,
                $projectEnvironment
            );

        // Save host
        $this->modelManager
            ->getHostRepository()
            ->save($host);

        // Host task queue
        $taskQueue = $this->taskManager
            ->createHostTaskQueue($host);

        $this->taskManager->pushTaskQueue($taskQueue);
    }
}
