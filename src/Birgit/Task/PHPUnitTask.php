<?php

namespace Birgit\Task;

use Birgit\Component\Task\Task;
use Birgit\Component\Task\TaskManager;
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
	public function execute(TaskManager $taskManager, Build $build)
	{
		// Get host
		$host = $build->getHost();

		// Clone command
		$command = (new Command())
			->setCommand('phpunit');

		$taskManager->runHostCommand($host, $command);
	}
}
