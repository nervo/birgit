<?php

namespace Birgit\Component\Task;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Model\Task\TaskRepositoryInterface;
use Birgit\Component\Task\Handler\TaskHandler;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Component\Task\Model\Task\Queue\TaskQueueStatus;
use Birgit\Component\Task\Model\Task\Queue\TaskQueueRepositoryInterface;
use Birgit\Component\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Component\Task\Queue\Context\TaskQueueContext;
use Birgit\Component\Type\TypeDefinition;
use Birgit\Component\Type\TypeResolver;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

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

    public function handleTask(Task $task, TaskQueueContextInterface $context)
    {
        return new TaskHandler(
            $task,
            $this->taskTypeResolver->resolve($task),
            $context
        );
    }

    public function handleTaskQueue(TaskQueue $taskQueue, TaskQueueContextInterface $context)
    {
        return new TaskQueueHandler(
            $taskQueue,
            $this->taskQueueTypeResolver->resolve($taskQueue),
            $context
        );
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

    public function launch(
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        while (true) {
            foreach ($this->taskQueueRepository as $taskQueue) {

                $taskQueueFound = $this->findChildlessPendingTaskQueue($taskQueue);

                if ($taskQueueFound) {

                    // Update
                    $taskQueueFound
                        ->setStatus(new TaskQueueStatus(TaskQueueStatus::RUNNING))
                        ->incrementAttempts();

                    // Save
                    $this->taskQueueRepository
                        ->save($taskQueueFound);

                    // Run
                    try {

                        // Create Task Queue Context
                        $taskQueueContext = new TaskQueueContext(
                            $taskQueueFound,
                            $this,
                            $eventDispatcher,
                            $logger
                        );

                        $this->handleTaskQueue($taskQueueFound, $taskQueueContext)
                            ->run();

                        // Delete
                        $this->taskQueueRepository
                            ->delete($taskQueueFound);
                    } catch (SuspendTaskQueueException $exception) {
                        // Update
                        $taskQueueFound
                            ->setStatus(new TaskQueueStatus(TaskQueueStatus::PENDING));

                        // Save
                        $this->taskQueueRepository
                            ->save($taskQueueFound);
                    }
                }
            }

            //sleep(3);
        }
    }

    protected function findChildlessPendingTaskQueue(TaskQueue $taskQueue)
    {
        if (!$taskQueue->hasChildren() && $taskQueue->getStatus()->isPending()) {
            return $taskQueue;
        } else {
            foreach ($taskQueue->getChildren() as $taskQueueChild) {
                $taskQueueReturn = $this->findChildlessPendingTaskQueue($taskQueueChild);
                if ($taskQueueReturn) {
                    return $taskQueueReturn;
                }
            }
        }

        return null;
    }
}
