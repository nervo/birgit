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
     * Constructor
     *
     * @param Task                      $task
     * @param TaskTypeInterface         $taskType
     */
    public function __construct(
        Task $task,
        TaskTypeInterface $taskType
    ) {
        // Task
        $this->task = $task;

        // Task type
        $this->taskType = $taskType;
    }

    /**
     * Run
     *
     * @param TaskQueueContextInterface $context
     */
    public function run(TaskQueueContextInterface $context)
    {
        $this->taskType->run(
            $this->task,
            $context
        );
    }
}
