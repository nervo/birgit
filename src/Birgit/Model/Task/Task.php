<?php

namespace Birgit\Model\Task;

use Birgit\Component\Type\TypeModel;

abstract class Task extends TypeModel
{
    /**
     * Queue
     *
     * @var Queue\TaskQueue
     */
    protected $queue;
    
    /**
     * Set queue
     *
     * @param Queue\TaskQueue $queue
     *
     * @return Task
     */
    public function setQueue(Queue\TaskQueue $queue)
    {
        $this->queue = $queue;

        return $this;
    }

    /**
     * Get queue
     *
     * @return Queue\TaskQueue
     */
    public function getQueue()
    {
        return $this->queue;
    }
}
