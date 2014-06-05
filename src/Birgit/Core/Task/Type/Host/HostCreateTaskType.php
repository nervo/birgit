<?php

namespace Birgit\Core\Task\Type\Host;

use Birgit\Component\Task\Type\TaskType;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Core\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;

/**
 * Host - Create Task Type
 */
class HostCreateTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
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
        $projectEnvironment = $this->modelRepositoryManager
            ->getProjectEnvironmentRepository()
            ->get(
                $task->getTypeDefinition()->getParameter('project_environment_name'),
                $projectReference->getProject()
            );

        // Create host
        $host = $this->modelRepositoryManager
            ->getHostRepository()
            ->create(
                $projectReference,
                $projectEnvironment
            );

        // Save host
        $this->modelRepositoryManager
            ->getHostRepository()
            ->save($host);

        // Host task queue
        $taskQueue = $this->taskManager
            ->createHostTaskQueue($host);

        $this->taskManager->pushTaskQueue($taskQueue);
    }
}
