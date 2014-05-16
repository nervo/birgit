<?php

namespace Birgit\Bundle\TestBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Birgit\Component\Parameters\Parameters;

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
        // Get task manager
        $taskManager = $this->getContainer()
            ->get('birgit.task_manager');
        
        $taskQueue = $taskManager
            ->createTaskQueue('cron')
                ->addTask(
                    $taskManager->createTask(
                        'project_check',
                        new Parameters(array(
                            'project_name' => 'test'
                        ))
                    )
                );
        
        $taskManager
            ->getTaskQueueHandler($taskQueue)
                ->run($taskQueue);
    }
}
