<?php

namespace Birgit\Component\Task;

use Psr\Log\LoggerInterface;

/**
 * Task Context
 */
class TaskContext
{
    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        // Logger
        $this->logger = $logger;
    }

    public function getLogger()
    {
    	return $this->logger;
    }
}
