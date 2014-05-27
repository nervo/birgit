<?php

namespace Birgit\Bundle\TestBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Birgit\Domain\Handler\HandlerDefinition;
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
        // Get model manager
        $modelManager = $this->getContainer()
            ->get('birgit.model_manager');

        // Get handler manager
        $handlerManager = $this->getContainer()
            ->get('birgit.handler_manager');

        // Create task queue
        $taskQueue = $modelManager
            ->getTaskQueueRepository()
            ->create(
                new HandlerDefinition(
                    'project',
                    new Parameters(array(
                        'project_name' => 'test'
                    ))
                )
            );
        
        // Add task
        $taskQueue
            ->addTask(
                $modelManager
                    ->getTaskRepository()
                    ->create(
                        new HandlerDefinition(
                            'project_status'
                        )
                    )
            );

        $handlerManager
            ->getTaskQueueHandler($taskQueue)
                ->run($taskQueue);
    }
}
