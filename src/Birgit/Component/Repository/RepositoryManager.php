<?php

namespace Birgit\Component\Repository;

use Psr\Log\LoggerInterface;

use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\ProcessBuilder;

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

    /**
     * Get repository references
     *
     * @param Repository $repository
     *
     * @return array
     */
    public function getRepositoryReferences(Repository $repository)
    {
        // Find git executable
        $executableFinder = new ExecutableFinder();
        $gitExecutable = $executableFinder->find('git', '/usr/bin/git');

        $builder = new ProcessBuilder();
        $process = $builder
            ->setPrefix($gitExecutable)
            ->setArguments(array('ls-remote', $repository->getPath()))
            ->getProcess();

        // Log command input
        $this->logger->notice($process->getCommandLine());

        $process->run();

        $lines = explode("\n", rtrim($process->getOutput()));

        // Log command output
        foreach ($lines as $line) {
            $this->logger->info($line);
        }

        $references = array();
        
        foreach ($lines as $line) {
            list($hash, $reference) = explode("\t", $line);
            if (strpos($reference, 'refs/') === 0) {
                $references[str_replace('refs/', '', $reference)] = $hash;
            }
        }

        return $references;
    }
}
