<?php

namespace Birgit\Core\Bundle\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Ratchet;
use React\EventLoop\Factory as LoopFactory;

use Birgit\Core\Websocket\WebsocketTaskServer;

/**
 * Websocket command
 */
class WebsocketCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('birgit:websocket')
            ->setDescription('Birgit Websocket')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command launch websocket server:

<info>php %command.full_name%</info>

EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $host = 'localhost';
        $port = 8080;
        $bind = '127.0.0.1';

        // Logger
        $logger = $this->getContainer()->get('logger');
        $logger->notice(sprintf(
            'Start websocket server on %s:%d bind on %s',
            $host,
            $port,
            $bind
        ));

        // Server
        $taskServer = new WebsocketTaskServer(
            $logger
        );

        // Loop
        $loop = LoopFactory::create();

        // Event dispatcher
        $eventDispatcher = $this->getContainer()->get('birgit.event_dispatcher');
        $eventDispatcher
            ->addSubscriber($taskServer);

        $loop->addPeriodicTimer(1, function() use ($eventDispatcher) {
            $eventDispatcher->check();
        });

        // Application
        $application = new Ratchet\App(
            $host,
            $port,
            $bind,
            $loop
        );
        $application->route('/task', $taskServer);

        // Main
        $loop->run();
    }
}
