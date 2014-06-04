<?php

namespace Birgit\Component\Task\Queue\Context;

use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

/**
 * Task queue Context Interface
 */
interface TaskQueueContextInterface
{
    public function getTaskQueue();

    public function getEventDispatcher();

    public function getLogger();
}
