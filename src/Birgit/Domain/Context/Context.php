<?php

namespace Birgit\Domain\Context;

use Psr\Log\LoggerInterface;

abstract class Context implements ContextInterface
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getLogger()
    {
        return $this->logger;
    }
}
