<?php

namespace Birgit\Component\Task;

use Psr\Log\LoggerInterface;

/**
 * Task manager
 */
class TaskManager
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
     * Execute task
     *
     * @param Task $task
     */
    public function executeTask(Task $task)
    {
    }
}
