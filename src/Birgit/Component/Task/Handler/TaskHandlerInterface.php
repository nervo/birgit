<?php

namespace Birgit\Component\Task\Handler;

use Birgit\Component\Handler\HandlerInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

/**
 * Task Handler Interface
 */
interface TaskHandlerInterface extends HandlerInterface
{
    /**
     * Run task
     *
     * @param Task                      $task
     * @param TaskQueueContextInterface $context
     */
    public function run(Task $task, TaskQueueContextInterface $context);
}
