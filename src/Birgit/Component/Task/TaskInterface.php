<?php

namespace Birgit\Component\Task;

/**
 * Task Interface
 */
interface TaskInterface
{
	public function execute(TaskContext $context);
}
