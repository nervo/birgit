<?php

namespace Birgit\Core\Bundle\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use React\EventLoop\Factory as LoopFactory;

/**
 * Worker command
 */
class WorkerCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('birgit:worker')
            ->setDescription('Birgit Worker')
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
        // Logger
        $logger = $this->getContainer()->get('logger');
        $logger->notice(sprintf(
            'Start worker'
        ));

        // Loop
        $loop = LoopFactory::create();

        $loop->addPeriodicTimer(1, function() {
            // Get task manager
            $taskManager = $this->getContainer()
                ->get('birgit.task_manager');

            $taskManager->loop(
                $this->getContainer()->get('event_dispatcher'),
                $this->getContainer()->get('logger')
            );
        });

        // Main
        $loop->run();
    }
}
