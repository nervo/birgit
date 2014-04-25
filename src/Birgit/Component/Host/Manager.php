<?php

namespace Birgit\Component\Host;

use Psr\Log\LoggerInterface;

use Birgit\Entity\HostProvider;
use Birgit\Entity\Host;

/**
 * Host manager
 */
class Manager
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

    /**
     * Create host
     *
     * @param HostProvider $hostProvider
     *
     * @return Host
     */
	public function createHost(HostProvider $hostProvider)
	{
		$host = new Host();

		return $host;
	}
}
