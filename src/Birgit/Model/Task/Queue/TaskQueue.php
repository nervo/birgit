<?php

namespace Birgit\Model\Task\Queue;

use Birgit\Component\Type\TypeModel;
use Birgit\Model\Task\Task;

/**
 * Task queue
 */
abstract class TaskQueue extends TypeModel
{
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
}
