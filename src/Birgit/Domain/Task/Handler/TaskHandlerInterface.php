<?php

namespace Birgit\Domain\Task\Handler;

use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Model\Task\Task;
use Birgit\Domain\Handler\HandlerInterface;

/**
 * Task Handler Interface
 */
interface TaskHandlerInterface extends HandlerInterface
{
    public function run(Task $task, TaskQueueContext $context);
}
