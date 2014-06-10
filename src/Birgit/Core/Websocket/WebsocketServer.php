<?php

namespace Birgit\Core\Websocket;

use Psr\Log\LoggerInterface;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * Websocket Server
 */
class WebsocketServer implements MessageComponentInterface
{
    protected $logger;
    protected $clients;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $connection)
    {
        $this->clients->attach($connection);

        $this->logger->notice(sprintf(
            'New connection: %d',
            $connection->resourceId
        ));
    }

    public function onMessage(ConnectionInterface $from, $message)
    {
        $numRecv = count($this->clients) - 1;

        $this->logger->notice(sprintf(
            'Connection %d sending message "%s" to %d other connection(s)',
            $from->resourceId,
            $message,
            count($this->clients) - 1
        ));

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($message);
            }
        }
    }

    public function onClose(ConnectionInterface $connection)
    {
        $this->clients->detach($connection);

        $this->logger->notice(sprintf(
            'Connection %d has disconnected',
            $connection->resourceId
        ));
    }

    public function onError(ConnectionInterface $connection, \Exception $exception)
    {
        $this->logger->warning(sprintf(
            'An error has occurred: %s',
            $exception->getMessage
        ));

        $connection->close();
    }
}
