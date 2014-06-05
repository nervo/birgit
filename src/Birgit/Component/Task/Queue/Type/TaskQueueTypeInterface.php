<?php

namespace Birgit\Component\Task\Queue\Type;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 * Task Queue Type Interface
 */
interface TaskQueueTypeInterface
{
    /**
     * Run
     *
     * @param TaskQueue                 $taskQueue
     * @param TaskQueueContextInterface $context
     */
    public function run(TaskQueue $taskQueue, TaskQueueContextInterface $context);
}
