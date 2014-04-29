<?php

namespace Birgit\Task;

use Birgit\Component\Task\Task;
use Birgit\Component\Task\TaskContext;
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
	public function execute(TaskContext $context)
	{
		$repositoryPath = $context
			->getBuild()
			->getRepositoryReferenceRevision()
			->getReference()
			->getRepository()
			->getPath();

		// Ensure workspace is a clone of repository
		$command = (new Command())
			->setCommand('git')
			->addArgument('config')
			->addArgument('--get')
			->addArgument('remote.origin.url');

		$worskpaceRepositoryPath = trim($context->runCommand($command));

		if ($worskpaceRepositoryPath !== $repositoryPath) {
			// Clone command
			$command = (new Command())
				->setCommand('git')
				->addArgument('clone')
				->addArgument($repositoryPath)
				->addArgument('.');

			$context->runCommand($command);
		} else {
			// Fetch command
			$command = (new Command())
				->setCommand('git')
				->addArgument('fetch');

			$context->runCommand($command);

			// Checkout command
			$command = (new Command())
				->setCommand('git')
				->addArgument('checkout')
				->addArgument(
					$context
						->getBuild()
						->getRepositoryReferenceRevision()
						->getHash()
				);

			$context->runCommand($command);
		}
	}
}
