<?php

namespace Birgit\Core\Bundle\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        // Get task manager
        $taskManager = $this->getContainer()
            ->get('birgit.task_manager');

        $taskManager->launch(
            $this->getContainer()->get('event_dispatcher'),
            $this->getContainer()->get('logger')
        );
    }
}
