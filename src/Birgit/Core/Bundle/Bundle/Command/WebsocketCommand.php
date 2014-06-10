<?php

namespace Birgit\Core\Bundle\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

use Birgit\Core\Websocket\WebsocketServer;

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
        // Get logger
        $logger = $this->getContainer()->get('logger');

        $port = 8080;

        $logger->notice(sprintf('Start websocket server on port: %d', $port));

        // Set server
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new WebsocketServer(
                        $logger
                    )
                )
            ),
            $port
        );

        $server->run();
    }
}
