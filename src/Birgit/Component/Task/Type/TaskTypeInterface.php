<?php

namespace Birgit\Component\Task\Type;

use Birgit\Component\Type\TypeInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

/**
 * Task Type Interface
 */
interface TaskTypeInterface extends TypeInterface
{
    /**
     * Run task
     *
     * @param Task                      $task
     * @param TaskQueueContextInterface $context
     */
    public function run(Task $task, TaskQueueContextInterface $context);
}
