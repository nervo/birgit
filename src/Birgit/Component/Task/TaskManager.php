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
use Birgit\Component\Task\Model\Task\Queue\TaskQueuesIterator;

/**
 * Task Manager
 */
class TaskManager
{
    /**
     * Task repository
     *
     * @var TaskRepositoryInterface
     */
    protected $taskRepository;

    /**
     * Task type resolver
     *
     * @var TypeResolver
     */
    protected $taskTypeResolver;
    
    /**
     * Task queue repository
     * 
     * @var TaskQueueRepositoryInterface
     */
    protected $taskQueueRepository;

    /**
     * Task queue type resolver
     * 
     * @var TypeResolver
     */
    protected $taskQueueTypeResolver;

    /**
     * Constructor
     *
     * @param TaskRepositoryInterface      $taskRepository
     * @param TypeResolver                 $taskTypeResolver
     * @param TaskQueueRepositoryInterface $taskQueueRepository
     * @param TypeResolver                 $taskQueueTypeResolver
     */
    public function __construct(
        TaskRepositoryInterface $taskRepository,
        TypeResolver $taskTypeResolver,
        TaskQueueRepositoryInterface $taskQueueRepository,
        TypeResolver $taskQueueTypeResolver
    ) {
        // Task repository
        $this->taskRepository = $taskRepository;

        // Task type resolver
        $this->taskTypeResolver = $taskTypeResolver;

        // Task queue repository
        $this->taskQueueRepository = $taskQueueRepository;

        // Task queue type resolver
        $this->taskQueueTypeResolver = $taskQueueTypeResolver;
    }

    /**
     * Get task repository
     * 
     * @return TaskRepositoryInterface
     */
    public function getTaskRepository()
    {
        return $this->taskRepository;
    }

    /**
     * Get task queue repository
     *
     * @return TaskQueueRepositoryInterface
     */
    public function getTaskQueueRepository()
    {
        return $this->taskQueueRepository;
    }

    /**
     * Handle task
     *
     * @param Task $task
     *
     * @return TaskHandler
     */
    public function handleTask(Task $task)
    {
        return new TaskHandler(
            $task,
            $this->taskTypeResolver->resolve($task)
        );
    }

    /**
     * Handle task queue
     *
     * @param TaskQueue $taskQueue
     *
     * @return TaskQueueHandler
     */
    public function handleTaskQueue(TaskQueue $taskQueue)
    {
        return new TaskQueueHandler(
            $taskQueue,
            $this->taskQueueTypeResolver->resolve($taskQueue),
            $this->taskQueueRepository
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

            // Push task
            $this
                ->handleTaskQueue($taskQueue)
                ->pushTask(
                    $this->createTask($taskType, $taskParameters)
                );
        }

        return $taskQueue;
    }

    /**
     * Create task
     *
     * @param string $type
     * @param array  $parameters
     */
    public function createTask($type, array $parameters = array())
    {
        return $this->taskRepository
            ->create(
                new TypeDefinition(
                    (string) $type,
                    $parameters
                )
            );
    }

    /**
     * Push task queue
     *
     * @param TaskQueue $taskQueue
     */
    public function pushTaskQueue(TaskQueue $taskQueue)
    {
        // Save task queue
        $this->taskQueueRepository
            ->save($taskQueue);
    }

    /**
     * Loop
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param LoggerInterface          $logger
     */
    public function loop(
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        // Create task queues iterator
        $taskQueues = new TaskQueuesIterator(
            $this->taskQueueRepository
        );

        foreach ($taskQueues as $taskQueue) {

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

            // Save
            $this->taskQueueRepository
                ->save($taskQueue);

            // Log
            $logger->notice(sprintf('Task Queue: "%s"', $taskQueue->getTypeDefinition()->getAlias()), $taskQueue->getTypeDefinition()->getParameters());

            // Run
            try {

                $this->handleTaskQueue($taskQueue)
                    ->run(
                        new TaskQueueContext(
                            $taskQueue,
                            $this,
                            $eventDispatcher,
                            $logger
                        )
                    );

                // Update status
                $taskQueue
                    ->setStatus(new TaskQueueStatus(TaskQueueStatus::FINISHED));

            } catch (SuspendTaskQueueException $exception) {

                // Log
                $logger->notice(sprintf('! Task Queue Suspended: "%s"', $taskQueue->getTypeDefinition()->getAlias()), $taskQueue->getTypeDefinition()->getParameters());

                // Update status
                $taskQueue
                    ->setStatus(new TaskQueueStatus(TaskQueueStatus::PENDING));
            }

            // Save
            $this->taskQueueRepository
                ->save($taskQueue);
        }
    }
}
