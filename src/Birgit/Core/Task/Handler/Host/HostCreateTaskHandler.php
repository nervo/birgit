<?php

namespace Birgit\Core\Task\Handler\Host;

use Birgit\Component\Task\Handler\TaskHandler;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Core\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;

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
            throw new ContextTaskQueueException();
        }

        // Get project reference
        $projectReference = $context->getProjectReference();

        // Get project environment
        $projectEnvironment = $this->modelManager
            ->getProjectEnvironmentRepository()
            ->get(
                $task->getTypeDefinition()->getParameter('project_environment_name'),
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
