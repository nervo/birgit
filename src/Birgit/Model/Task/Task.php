<?php

namespace Birgit\Model\Task;

use Birgit\Domain\Handler\Handleable;
use Birgit\Model\Task\Queue\TaskQueue;

/**
 * Task
 */
abstract class Task implements Handleable
{
    /**
     * Get queue
     *
     * @return TaskQueue
     */
    abstract public function getQueue();
}
