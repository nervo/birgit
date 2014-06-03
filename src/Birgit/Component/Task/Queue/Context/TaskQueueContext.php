<?php

namespace Birgit\Component\Task\Queue\Context;

use Birgit\Component\Context\ContextInterface;
use Birgit\Model\Task\Queue\TaskQueue;

/**
 * Task queue Context
 */
class TaskQueueContext implements TaskQueueContextInterface
{
    protected $taskQueue;
    protected $context;

    public function __construct(
        TaskQueue $taskQueue,
        ContextInterface $context
    ) {
        $this->taskQueue = $taskQueue;
        $this->context = $context;
    }

    public function getTaskQueue()
    {
        return $this->taskQueue;
    }

    public function getEventDispatcher()
    {
        return $this->context->getEventDispatcher();
    }

    public function getLogger()
    {
        return $this->context->getLogger();
    }
}
