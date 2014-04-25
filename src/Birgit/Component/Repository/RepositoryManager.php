<?php

namespace Birgit\Component\Repository;

use Psr\Log\LoggerInterface;

 use Birgit\Component\Repository\Git;

use Birgit\Entity\Repository;

/**
 * Repository manager
 */
class RepositoryManager
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
     * Create client
     *
     * @param Repository $repository
     *
     * @return Git\Client
     */
	public function createclient(Repository $repository)
	{
		$client = (new Git\Client())
			->setRepository($repository->getPath());

		return $client;
	}
}
