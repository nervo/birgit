<?php

namespace Birgit\Component\Task;

use Birgit\Component\Task\TaskContext;
use Birgit\Component\Command\Command;

use Birgit\Entity\Build;

/**
 * Task
 */
abstract class Task
{
    /**
     * Execute
     *
     * @param TaskContext $context
     */
	abstract public function execute(TaskContext $context);
}
