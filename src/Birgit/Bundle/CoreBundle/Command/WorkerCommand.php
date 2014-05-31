<?php

namespace Birgit\Bundle\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Birgit\Domain\Context\Context;

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
        // Get worker
        $worker = $this->getContainer()
            ->get('birgit.worker');

        $worker->run(
            new Context(
                $this->getContainer()->get('event_dispatcher'),
                $this->getContainer()->get('logger')
            )
        );
    }
}
