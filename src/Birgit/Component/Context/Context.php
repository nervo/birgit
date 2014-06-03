<?php

namespace Birgit\Component\Context;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

class Context implements ContextInterface
{
    protected $eventDispatcher;
    protected $logger;

    public function __construct(EventDispatcherInterface $eventDispatcher, LoggerInterface $logger)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }

    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    public function getLogger()
    {
        return $this->logger;
    }
}
