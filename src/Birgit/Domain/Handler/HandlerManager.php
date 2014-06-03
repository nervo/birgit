<?php

namespace Birgit\Domain\Handler;

use Birgit\Component\Handler\HandlerManager as BaseHandlerManager;
use Birgit\Domain\Project\Handler\ProjectHandlerInterface;
use Birgit\Model\Project\Project;
use Birgit\Domain\Project\Environment\Handler\ProjectEnvironmentHandlerInterface;
use Birgit\Model\Project\Environment\ProjectEnvironment;
use Birgit\Component\Task\Handler\TaskHandlerInterface;
use Birgit\Component\Task\Queue\Handler\TaskQueueHandlerInterface;
use Birgit\Model\Task\Task;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Domain\Exception\Exception;

/**
 * Handler Manager
 */
class HandlerManager extends BaseHandlerManager
{
    /**
     * Project handlers
     *
     * @var array
     */
    protected $projectHandlers = array();

    /**
     * Project environment handlers
     *
     * @var array
     */
    protected $projectEnvironmentHandlers = array();

    /**
     * Task handlers
     *
     * @var array
     */
    protected $taskHandlers = array();

    /**
     * Task queue handlers
     *
     * @var array
     */
    protected $taskQueueHandlers = array();

    /**
     * Add Project handler
     *
     * @param ProjectHandlerInterface $handler
     *
     * @return HandlerManager
     */
    public function addProjectHandler(ProjectHandlerInterface $handler)
    {
        $this->projectHandlers[] = $handler;

        return $this;
    }

    /**
     * Get project Handler
     *
     * @param Project $project
     *
     * @return ProjectHandlerInterface
     *
     * @throws Exception
     */
    public function getProjectHandler(Project $project)
    {
        $type = $project->getHandlerDefinition()->getType();

        foreach ($this->projectHandlers as $handler) {
            if ($handler->getType() === $type) {
                return $handler;
            }
        }

        throw new Exception(sprintf('Project handler type "%s" not found', $type));
    }

    /**
     * Add Project Environment Handler
     *
     * @param ProjectEnvironmentHandlerInterface $handler
     *
     * @return HandlerManager
     */
    public function addProjectEnvironmentHandler(ProjectEnvironmentHandlerInterface $handler)
    {
        $this->projectEnvironmentHandlers[] = $handler;

        return $this;
    }

    /**
     * Get Project Environment Handler
     *
     * @param ProjectEnvironment $projectEnvironment
     *
     * @return ProjectEnvironmentHandlerInterface
     *
     * @throws Exception
     */
    public function getProjectEnvironmentHandler(ProjectEnvironment $projectEnvironment)
    {
        $type = $projectEnvironment->getHandlerDefinition()->getType();

        foreach ($this->projectEnvironmentHandlers as $handler) {
            if ($handler->getType() === $type) {
                return $handler;
            }
        }

        throw new Exception(sprintf('Project environment handler type "%s" not found', $type));
    }

    /**
     * Add Task Handler
     *
     * @param TaskHandlerInterface $handler
     *
     * @return HandlerManager
     */
    public function addTaskHandler(TaskHandlerInterface $handler)
    {
        $this->taskHandlers[] = $handler;

        return $this;
    }

    /**
     * Get Task Handler
     *
     * @param Task $task
     *
     * @return TaskHandlerInterface
     *
     * @throws Exception
     */
    public function getTaskHandler(Task $task)
    {
        $type = $task->getHandlerDefinition()->getType();

        foreach ($this->taskHandlers as $handler) {
            if ($handler->getType() === $type) {
                return $handler;
            }
        }

        throw new Exception(sprintf('Task handler type "%s" not found', $type));
    }

    /**
     * Add Task Queue Handler
     *
     * @param TaskQueueHandlerInterface $handler
     *
     * @return HandlerManager
     */
    public function addTaskQueueHandler(TaskQueueHandlerInterface $handler)
    {
        $this->taskQueueHandlers[] = $handler;

        return $this;
    }

    /**
     * Get Task Queue Handler
     *
     * @param TaskQueueHandlerInterface $taskQueue
     *
     * @return type
     *
     * @throws Exception
     */
    public function getTaskQueueHandler(TaskQueue $taskQueue)
    {
        $type = $taskQueue->getHandlerDefinition()->getType();

        foreach ($this->taskQueueHandlers as $handler) {
            if ($handler->getType() === $type) {
                return $handler;
            }
        }

        throw new Exception(sprintf('Task queue handler type "%s" not found', $type));
    }
}
