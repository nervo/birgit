<?php

namespace Birgit\Domain\Task\Handler;

use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Model\Task\Task;
use Birgit\Component\Type\TypeHandlerInterface;

/**
 * Task Handler Interface
 */
interface TaskHandlerInterface extends TypeHandlerInterface
{
    public function run(Task $task, TaskQueueContext $context);
}
