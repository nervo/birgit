<?php

namespace Birgit\Component\Task;

use Birgit\Component\Task\Model\Task\TaskRepositoryInterface;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Component\Task\Model\Task\Queue\TaskQueueRepositoryInterface;
use Birgit\Component\Type\TypeDefinition;
use Birgit\Component\Type\TypeResolver;

/**
 * Task Manager
 */
class TaskManager
{
    protected $taskRepository;
    protected $taskTypeResolver;
    protected $taskQueueRepository;
    protected $taskQueueTypeResolver;

    public function __construct(
        TaskRepositoryInterface $taskRepository,
        TypeResolver $taskTypeResolver,
        TaskQueueRepositoryInterface $taskQueueRepository,
        TypeResolver $taskQueueTypeResolver
    ) {
        $this->taskRepository = $taskRepository;
        $this->taskTypeResolver = $taskTypeResolver;
        $this->taskQueueRepository = $taskQueueRepository;
        $this->taskQueueTypeResolver = $taskQueueTypeResolver;
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
                new TypeDefinition(
                    (string) $type,
                    $parameters
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
                            new TypeDefinition(
                                (string) $taskType,
                                $taskParameters
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
