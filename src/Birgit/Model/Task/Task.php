<?php

namespace Birgit\Model\Task;

use Birgit\Component\Handler\Handleable;
use Birgit\Component\Handler\HandlerDefinition;
use Birgit\Model\Task\Queue\TaskQueue;

/**
 * Task
 */
abstract class Task implements Handleable
{
    /**
     * Constructor
     *
     * @param TaskQueue         $queue
     * @param HandlerDefinition $handlerDefinition
     */
    public function __construct(TaskQueue $queue, HandlerDefinition $handlerDefinition)
    {
        $this
            ->setQueue($queue)
            ->setHandlerDefinition($handlerDefinition);
    }

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

    /**
     * Set Handler Definition
     *
     * @param HandlerDefinition $handlerDefinition
     *
     * @return Task
     */
    abstract public function setHandlerDefinition(HandlerDefinition $handlerDefinition);
}
