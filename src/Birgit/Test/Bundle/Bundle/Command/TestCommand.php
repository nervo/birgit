<?php

namespace Birgit\Test\Bundle\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Test command
 */
class TestCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('birgit:test')
            ->setDescription('Birgit test')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command does things:

<info>php %command.full_name%</info>

EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get model repository manager
        $modelRepositoryManager = $this->getContainer()
            ->get('birgit.model_repository_manager');

        // Get project
        $project = $modelRepositoryManager
            ->getProjectRepository()
            ->get('test');

        // Get task manager
        $taskManager = $this->getContainer()
            ->get('birgit.task_manager');

        // Push task queue
        $taskManager->pushTaskQueue(
            $taskManager->createProjectTaskQueue($project, [
                'project'
            ])
        );
    }
}
