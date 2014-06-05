<?php

namespace Birgit\Component\Task\Queue\Handler;

use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Component\Task\Queue\Type\TaskQueueTypeInterface;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

/**
 * Task Queue Handler
 */
class TaskQueueHandler
{
    /**
     * Task Queue
     *
     * @var TaskQueue
     */
    protected $taskQueue;

    /**
     * Task Queue Type
     *
     * @var TaskQueueTypeInterface
     */
    protected $taskQueueType;

    /**
     * Task Queue Context
     *
     * @var TaskQueueContextInterface
     */
    protected $taskQueueContext;

    /**
     * Constructor
     *
     * @param TaskQueue                 $taskQueue
     * @param TaskQueueTypeInterface    $taskQueueType
     * @param TaskQueueContextInterface $taskQueueContext
     */
    public function __construct(
        TaskQueue $taskQueue,
        TaskQueueTypeInterface $taskQueueType,
        TaskQueueContextInterface $taskQueueContext
    ) {
        // Task queue
        $this->taskQueue = $taskQueue;

        // Task queue type
        $this->taskQueueType = $taskQueueType;

        // Task queue context
        $this->taskQueueContext = $taskQueueContext;
    }

    /**
     * Run
     */
    public function run()
    {
        $this->taskQueueType->run(
            $this->taskQueue,
            $this->taskQueueContext
        );
    }
}
