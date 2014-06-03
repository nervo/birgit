<?php

namespace Birgit\Component\Task;

use Birgit\Model\ModelManagerInterface;
use Birgit\Component\Handler\HandlerDefinition;
use Birgit\Component\Parameters\Parameters;
use Birgit\Model\Task\Queue\TaskQueue;

/**
 * Task Manager
 */
class TaskManager
{
    protected $modelManager;

    public function __construct(
        ModelManagerInterface $modelManager
    ) {
        $this->modelManager   = $modelManager;
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
        $taskQueue = $this->modelManager
            ->getTaskQueueRepository()
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
                    $this->modelManager
                        ->getTaskRepository()
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
        $this->modelManager
            ->getTaskQueueRepository()
            ->save($taskQueue);
    }
}
