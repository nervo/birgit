<?php

namespace Birgit\Component\Repository;

use Psr\Log\LoggerInterface;

/**
 * Repository Context
 */
class RepositoryContext
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
