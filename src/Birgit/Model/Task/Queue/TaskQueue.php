<?php

namespace Birgit\Model\Task\Queue;

use Birgit\Component\Handler\Handleable;
use Birgit\Component\Handler\HandlerDefinition;
use Birgit\Model\Task\Task;

/**
 * Task queue
 */
abstract class TaskQueue implements Handleable
{
    /**
     * Constructor
     *
     * @param HandlerDefinition $handlerDefinition
     */
    public function __construct(HandlerDefinition $handlerDefinition)
    {
        $this
            ->setHandlerDefinition($handlerDefinition);
    }

    /**
     * Add task
     *
     * @param Task $task
     *
     * @return TaskQueue
     */
    abstract public function addTask(Task $task);

    /**
     * Remove task
     *
     * @param Task $task
     *
     * @return TaskQueue
     */
    abstract public function removeTask(Task $task);

    /**
     * Get tasks
     *
     * @return \Traversable
     */
    abstract public function getTasks();

    /**
     * Set Handler Definition
     *
     * @param HandlerDefinition $handlerDefinition
     *
     * @return Task
     */
    abstract public function setHandlerDefinition(HandlerDefinition $handlerDefinition);
}
