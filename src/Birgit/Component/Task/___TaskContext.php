<?php

namespace Birgit\Component\Task;

use Psr\Log\LoggerInterface;

use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Process\Process;

use Birgit\Component\Task\TaskManager;
use Birgit\Component\Command\Command;

use Birgit\Entity\Build;

/**
 * Task context
 */
class TaskContext
{
    /**
     * Build
     *
     * @var Build
     */
    protected $build;

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
     * @param Build           $build
     * @param string          $rootDir
     * @param LoggerInterface $logger
     */
	public function __construct(Build $build, $rootDir, LoggerInterface $logger)
	{
		// Build
		$this->build = $build;

        // Root dir
        $this->rootDir = $rootDir;

    	// Logger
    	$this->logger = $logger;
	}

    /**
     * Get build
     *
     * @return Build
     */
	public function getBuild()
	{
		return $this->build;
	}

    /**
     * Get logger
     *
     * @return LoggerInterface
     */
	public function getLogger()
	{
		return $this->logger;
	}

    /**
     * Run command
     *
     * @param Command $command
     *
     * @return string
     */
    public function runCommand(Command $command)
    {
    	// Get host
    	$host = $this->getBuild()->getHost();

        $builder = new ProcessBuilder();
        $process = $builder
            ->setWorkingDirectory($this->rootDir . '/' . $host->getWorkspace())
            ->setPrefix($command->getCommand())
            ->setArguments($command->getArguments())
            ->getProcess();

        // Log command input
        $this->getLogger()->notice($process->getCommandLine());

        $process->run();

        $lines = explode("\n", rtrim($process->getOutput()));

        // Log command output
        foreach ($lines as $line) {
            $this->getLogger()->info($line);
        }

        return $process->getOutput();
    }
}
