<?php

namespace Birgit\Component\Task\Handler;

use Birgit\Component\Handler\Handler;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

/**
 * Task Handler
 */
abstract class TaskHandler extends Handler implements TaskHandlerInterface
{
    abstract public function run(Task $task, TaskQueueContextInterface $context);
}
