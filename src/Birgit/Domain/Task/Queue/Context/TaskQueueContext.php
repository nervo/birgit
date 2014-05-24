<?php

namespace Birgit\Domain\Task\Queue\Context;

use Psr\Log\LoggerInterface;

use Birgit\Domain\Context\Context;
use Birgit\Model\Task\Queue\TaskQueue;

/**
 * Task queue Context
 */
class TaskQueueContext extends Context implements TaskQueueContextInterface
{
    protected $taskQueue;

    public function __construct(
        TaskQueue $taskQueue,
        LoggerInterface $logger
    ) {
        parent::__construct($logger);
        
        $this->taskQueue = $taskQueue;
    }

    public function getTaskQueue()
    {
        return $this->taskQueue;
    }
}
