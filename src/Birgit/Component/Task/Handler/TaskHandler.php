<?php

namespace Birgit\Component\Task\Handler;

use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Type\TaskTypeInterface;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

/**
 * Task Handler
 */
class TaskHandler
{
    /**
     * Task
     * 
     * @var Task
     */
    protected $task;
    
    /**
     * Task Type
     * 
     * @var TaskTypeInterface 
     */
    protected $taskType;
    
    /**
     * Task Queue Context
     * 
     * @var TaskQueueContextInterface
     */
    protected $taskQueueContext;
    
    /**
     * Constructor
     * 
     * @param Task                      $task
     * @param TaskTypeInterface         $taskType
     * @param TaskQueueContextInterface $taskQueueContext
     */
    public function __construct(
        Task $task,
        TaskTypeInterface $taskType,
        TaskQueueContextInterface $taskQueueContext
    ) {
        // Task
        $this->task = $task;
        
        // Task type
        $this->taskType = $taskType;
        
        // Task queue context
        $this->taskQueueContext = $taskQueueContext;
    }
    
    /**
     * Run
     */
    public function run()
    {
        $this->taskType->run(
            $this->task,
            $this->taskQueueContext
        );
    }
}
