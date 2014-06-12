<?php

namespace Birgit\Core\Project\Environment\Handler;

use Birgit\Core\Model\Project\Environment\ProjectEnvironment;
use Birgit\Core\Project\Environment\Type\ProjectEnvironmentTypeInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

/**
 * Project Environment Handler
 */
class ProjectEnvironmentHandler
{
    /**
     * Project Environment
     *
     * @var ProjectEnvironment
     */
    protected $projectEnvironment;

    /**
     * Project Environment Type
     *
     * @var ProjectEnvironmentTypeInterface
     */
    protected $projectEnvironmentType;

    /**
     * Constructor
     *
     * @param ProjectEnvironment              $projectEnvironment
     * @param ProjectEnvironmentTypeInterface $projectEnvironmentType
     */
    public function __construct(
        ProjectEnvironment $projectEnvironment,
        ProjectEnvironmentTypeInterface $projectEnvironmentType
    ) {
        // Project environment
        $this->projectEnvironment = $projectEnvironment;

        // Project environment type
        $this->projectEnvironmentType = $projectEnvironmentType;
    }

    /**
     * On host task
     * 
     * @param Task                      $task
     * @param TaskQueueContextInterface $context
     */
    public function onHostTask(Task $task, TaskQueueContextInterface $context)
    {
        $this->projectEnvironmentType
            ->onHostTask(
                $task,
                $context
            );
    }

    /**
     * On build task
     *
     * @param Task                      $task
     * @param TaskQueueContextInterface $context
     */
    public function onBuildTask(Task $task, TaskQueueContextInterface $context)
    {
        $this->projectEnvironmentType
            ->onBuildTask(
                $task,
                $context
            );
    }

    /**
     * Get workspace
     *
     * @param TaskQueueContextInterface $context
     */
    public function getWorkspace(TaskQueueContextInterface $context)
    {
        return $this->projectEnvironmentType
            ->getWorkspace(
                $this->projectEnvironment,
                $context
            );
    }
}
