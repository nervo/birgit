<?php

namespace Birgit\Component\Task;

use Birgit\Component\Task\TaskManager;
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
     * @param TaskManager $taskManager
     * @param Build       $build
     */
	abstract public function execute(TaskManager $taskManager, Build $build);
}
