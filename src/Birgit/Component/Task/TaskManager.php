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
use Birgit\Component\Task\Queue\Exception\SuspendTaskQueueException;

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
     * Launch
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param LoggerInterface          $logger
     */
    public function launch(
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        while (true) {
            foreach ($this->taskQueueRepository as $taskQueue) {

                // An already finished task queue must not be ran
                if ($taskQueue->getStatus()->isFinished()) {
                    continue;
                }

                // A task queue having unfinished predecessors must not be ran
                if ($taskQueue->hasPredecessors()) {
                    $finished = true;
                    foreach ($taskQueue->getPredecessors() as $taskQueuePredecessor) {
                        if (!$taskQueuePredecessor->getStatus()->isFinished()) {
                            $finished = false;
                            break;
                        }
                    }
                    if (!$finished) {
                        continue;
                    }
                }

                // A successor task queue having unfinished head must not be ran
                if (
                    $taskQueue->hasHead()
                    && !$taskQueue->getHead()->getStatus()->isFinished()
                ) {
                    continue;
                }

                // Update
                $taskQueue
                    ->setStatus(new TaskQueueStatus(TaskQueueStatus::RUNNING))
                    ->incrementAttempts();

                // Run
                try {

                    // Create Task Queue Context
                    $taskQueueContext = new TaskQueueContext(
                        $taskQueue,
                        $this,
                        $eventDispatcher,
                        $logger
                    );

                    $this->handleTaskQueue($taskQueue, $taskQueueContext)
                        ->run();

                    // Update status
                    $taskQueue
                        ->setStatus(new TaskQueueStatus(TaskQueueStatus::FINISHED));

                } catch (SuspendTaskQueueException $exception) {
                    // Update status
                    $taskQueue
                        ->setStatus(new TaskQueueStatus(TaskQueueStatus::PENDING));
                }

                // Save
                $this->taskQueueRepository
                    ->save($taskQueue);
            }

            sleep(3);
        }
    }
}
