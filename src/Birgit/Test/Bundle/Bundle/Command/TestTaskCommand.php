<?php

namespace Birgit\Test\Bundle\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Test Rask Command
 */
class TestTaskCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('birgit:test:task')
            ->setDescription('Birgit test task')
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
        // Get project
        $project = $this->getContainer()
            ->get('birgit.model_repository_manager')
            ->getProjectRepository()
            ->get('test');

        // Get task manager
        $taskManager = $this->getContainer()
            ->get('birgit.task_manager');

        // Create task queue
        $taskQueue = $taskManager
            ->createProjectTaskQueue($project, [
                'project'
            ]);

        // Push task queue
        $taskManager->pushTaskQueue($taskQueue);
    }
}
