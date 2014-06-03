<?php

namespace Birgit\Component\Task;

use Birgit\Component\Task\Model\Task\TaskRepositoryInterface;
use Birgit\Component\Task\Model\Task\Queue\TaskQueueRepositoryInterface;
use Birgit\Component\Handler\HandlerDefinition;
use Birgit\Component\Parameters\Parameters;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 * Task Manager
 */
class TaskManager
{
    protected $taskRepository;
    protected $taskQueueRepository;

    public function __construct(
        TaskRepositoryInterface $taskRepository,
        TaskQueueRepositoryInterface $taskQueueRepository
    ) {
        $this->taskRepository = $taskRepository;
        $this->taskQueueRepository = $taskQueueRepository;
    }

    /**
     * Create task queue
     *
     * @param string $type
     * @param array  $parameters
     * @param array  $tasks
     */
    public function createTaskQueue($type, array $parameters = array(), $tasks = array())
    {
        // Create task queue
        $taskQueue = $this->taskQueueRepository
            ->create(
                new HandlerDefinition(
                    (string) $type,
                    new Parameters($parameters)
                )
            );

        foreach ($tasks as $taskType => $taskParameters) {
            // Handle task type only
            if (is_numeric($taskType)) {
                $taskType = $taskParameters;
                $taskParameters = array();
            }
            // Add task
            $taskQueue
                ->addTask(
                    $this->taskRepository
                        ->create(
                            new HandlerDefinition(
                                (string) $taskType,
                                new Parameters((array) $taskParameters)
                            )
                        )
                );
        }

        return $taskQueue;
    }

    /**
     * Push Task queue
     *
     * @param TaskQueue $taskQueue
     */
    public function pushTaskQueue(TaskQueue $taskQueue)
    {
        $this->taskQueueRepository
            ->save($taskQueue);
    }
}
