<?php

namespace Birgit\Task;

use Birgit\Component\Task\Task;
use Birgit\Component\Task\TaskContext;
use Birgit\Component\Command\Command;

use Birgit\Entity\Build;

/**
 * PHPUnit task
 */
class PHPUnitTask extends Task
{
    /**
     * {@inheritdoc}
     */
	public function execute(TaskContext $context)
	{
		// Command
		$command = (new Command())
			->setCommand('phpunit');

		$context->runCommand($command);
	}
}
