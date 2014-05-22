<?php

namespace Birgit\Model\Task;

use Birgit\Component\Type\TypeModel;
use Birgit\Model\Task\Queue\TaskQueue;

abstract class Task extends TypeModel
{
    /**
     * Set queue
     *
     * @param TaskQueue $queue
     *
     * @return Task
     */
    abstract public function setQueue(TaskQueue $queue);

    /**
     * Get queue
     *
     * @return TaskQueue
     */
    abstract public function getQueue();
}
