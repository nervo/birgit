<?php

namespace Birgit\Base\Local\Project\Environment\Type;

use Birgit\Core\Project\Environment\Type\ProjectEnvironmentType;
use Birgit\Core\Model\Project\Environment\ProjectEnvironment;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

/**
 * Local Project environment type
 */
class LocalProjectEnvironmentType extends ProjectEnvironmentType
{
    /**
     * Root dir
     * 
     * @var string
     */
    protected $rootDir;

    /**
     * Constructor
     *
     * @param string $rootDir
     */
    public function __construct($rootDir)
    {
        // Root dir
        $this->rootDir = (string) $rootDir;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'local';
    }

    /**
     * {@inheritdoc}
     */
    public function onHostTask(Task $task, TaskQueueContextInterface $context)
    {
        // Get task manager
        $taskManager = $context->getTaskManager();

        // Get task queue
        $taskQueue = $context->getTaskQueue();

        $taskManager
            ->handleTaskQueue($taskQueue)
            ->pushTask(
                $taskManager->createTask('host_workspace_local')
            )
            ->pushTask(
                $taskManager->createTask('host_build')
            );
    }

    /**
     * Get workspace
     *
     * @param ProjectEnvironment        $projectEnvironment
     * @param TaskQueueContextInterface $context
     */
    public function getWorkspace(ProjectEnvironment $projectEnvironment, TaskQueueContextInterface $context)
    {
        return
            $this->rootDir .
            DIRECTORY_SEPARATOR .
            $projectEnvironment->getTypeDefinition()->getParameter('workspace');
    }
}
