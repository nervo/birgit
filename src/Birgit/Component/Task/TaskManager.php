<?php

namespace Birgit\Component\Task;

use Psr\Log\LoggerInterface;

use Birgit\Component\Command\Command;

use Birgit\Entity\Host;
use Birgit\Entity\Build;

/**
 * Task manager
 */
class TaskManager
{
    /**
     * Task types
     *
     * @var array
     */
    protected $taskTypes = array();
    
    public function addTaskType($type, TaskInterface $task)
    {
        $this->taskTypes[(string) $type] = $task;
    }
    
    public function getTaskType($type)
    {
        return $this->taskTypes[(string) $type];
    }
    
    /**
     * Root dir
     *
     * @var string
     */
    //protected $rootDir;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    //protected $logger;

    /**
     * Constructor
     *
     * @param string          $rootDir
     * @param LoggerInterface $logger
     */
    /*
    public function __construct($rootDir, LoggerInterface $logger)
    {
        // Root dir
        $this->rootDir = $rootDir;

        // Logger
        $this->logger = $logger;
    }
    */

    /**
     * Execute build task
     *
     * @param Build $build
     * @param Task  $task
     *
     * @return string
     */
    /*
    public function executeBuildTask(Build $build, Task $task)
    {
        $taskContext = new TaskContext($build, $this->rootDir, $this->logger);
        $task->execute($taskContext);
    }
    */
}
