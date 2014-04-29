<?php

namespace Birgit\Task;

use Birgit\Component\Task\Task;
use Birgit\Component\Task\TaskManager;
use Birgit\Component\Command\Command;

use Birgit\Entity\Build;

/**
 * Git checkout task
 */
class GitCheckoutTask extends Task
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
			->setCommand('git')
			->addArgument('clone')
			->addArgument(
				$build
					->getRepositoryReferenceRevision()
					->getReference()
					->getRepository()
					->getPath()
			)
			->addArgument('.');

		$taskManager->runHostCommand($host, $command);

		// Checkout command
		$command = (new Command())
			->setCommand('git')
			->addArgument('checkout')
			->addArgument(
				$build
					->getRepositoryReferenceRevision()
					->getHash()
			);

		$taskManager->runHostCommand($host, $command);
	}
}
