<?php

namespace Birgit\Component\Task\Handler;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Model\Task\Task;
use Birgit\Component\Handler\HandlerInterface;

/**
 * Task Handler Interface
 */
interface TaskHandlerInterface extends HandlerInterface
{
    public function run(Task $task, TaskQueueContextInterface $context);
}
