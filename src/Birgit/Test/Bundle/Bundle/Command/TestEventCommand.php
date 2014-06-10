<?php

namespace Birgit\Test\Bundle\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Birgit\Component\Event\Distant\DistantEvent;

/**
 * Test Event Command
 */
class TestEventCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('birgit:test:event')
            ->setDescription('Birgit test event')
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
        // Get event dispatcher
        $eventDispatcher = $this->getContainer()
            ->get('birgit.event_dispatcher');

        $eventDispatcher->dispatch('foo', new DistantEvent(array('foo' => 'bar')));
    }
}
