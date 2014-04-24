<?php

namespace Birgit\Component\Git;

use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Process\Process;

use Psr\Log\LoggerInterface;

/**
 * Git client
 */
class Client
{
    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Executable
     *
     * @var string
     */
    protected $executable;

    /**
     * Repository
     *
     * @var string
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger = null)
    {
    	// Logger
    	$this->logger = $logger;

    	// Find executable
    	$executableFinder = new ExecutableFinder();
    	$this->executable = $executableFinder->find('git', '/usr/bin/git');
    }

    /**
     * Set repository
     *
     * @param string $repository
     *
     * @return Client
     */
    public function setRepository($repository)
    {
    	$this->repository = (string) $repository;

    	return $this;
    }

    /**
     * Get branches
     *
     * @return array
     */
    public function getBranches()
    {
		$builder = new ProcessBuilder();
		$process = $builder
			->setPrefix($this->executable)
			->setArguments(array('ls-remote', '--heads', $this->repository))
			->getProcess();

		// Log command input
        if ($this->logger) {
        	$this->logger->notice($process->getCommandLine());
        }

		$process->run();

        $lines = explode("\n", rtrim($process->getOutput()));

		// Log command output
        if ($this->logger) {
        	foreach ($lines as $line) {
        		$this->logger->info($line);
        	}
        }

        $branches = array();
        foreach ($lines as $line) {
            list($hash, $reference) = explode("\t", $line);

            $branches[] = new Reference(str_replace('refs/heads/', '', $reference), $hash);
        }


		return $branches;
    }

    /**
     * Checkout
     *
     * @param string $directory
     */
    public function checkout($directory)
    {
		$builder = new ProcessBuilder();
		$process = $builder
			->setPrefix($this->executable)
			->setArguments(array('clone', $this->repository, $directory))
			->getProcess();

		// Log command input
        if ($this->logger) {
        	$this->logger->notice($process->getCommandLine());
        }

		$process->run();

        $lines = explode("\n", rtrim($process->getOutput()));

		// Log command output
        if ($this->logger) {
        	foreach ($lines as $line) {
        		$this->logger->info($line);
        	}
        }
    }
}
