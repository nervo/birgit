<?php

namespace Birgit\Core\Websocket;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use Birgit\Component\Event\Distant\DistantEvent;
use Birgit\Component\Task\Queue\TaskQueueEvents;

/**
 * Websocket Task Server
 */
class WebsocketTaskServer implements MessageComponentInterface, EventSubscriberInterface
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

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            TaskQueueEvents::CREATE => 'onTaskQueueEvent',
            TaskQueueEvents::UPDATE => 'onTaskQueueEvent'
        );
    }

    /**
     * On task queue event
     *
     * @param TaskQueueEvent $event
     * @param string         $eventName
     */
    public function onTaskQueueEvent(DistantEvent $event, $eventName)
    {
        $this->logger->info(sprintf(
            'Event: "%s"',
            $eventName
        ), $event->getParameters());

        foreach ($this->clients as $client) {
            $client->send(
                $eventName .
                ':' .
                json_encode($event->getParameters())
            );
        }
    }
}
