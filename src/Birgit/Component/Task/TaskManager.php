<?php

namespace Birgit\Component\Task;

use Psr\Log\LoggerInterface;

use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Process\Process;

use Birgit\Component\Command\Command;

use Birgit\Entity\Host;

/**
 * Task manager
 */
class TaskManager
{
    /**
     * Root dir
     *
     * @var string
     */
    protected $rootDir;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor
     *
     * @param string          $rootDir
     * @param LoggerInterface $logger
     */
	public function __construct($rootDir, LoggerInterface $logger)
	{
        // Root dir
        $this->rootDir = $rootDir;

    	// Logger
    	$this->logger = $logger;
	}

    /**
     * Run host command
     *
     * @param Host    $host
     * @param Command $command
     *
     * @return string
     */
    public function runHostCommand(Host $host, Command $command)
    {
        $builder = new ProcessBuilder();
        $process = $builder
            ->setWorkingDirectory($this->rootDir . '/' . $host->getWorkspace())
            ->setPrefix($command->getCommand())
            ->setArguments($command->getArguments())
            ->getProcess();

        // Log command input
        $this->logger->notice($process->getCommandLine());

        $process->run();

        $lines = explode("\n", rtrim($process->getOutput()));

        // Log command output
        foreach ($lines as $line) {
            $this->logger->info($line);
        }

        return $process->getOutput();
    }
}
