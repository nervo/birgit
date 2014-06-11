<?php

namespace Birgit\Component\Task\Queue\Handler;

use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Component\Task\Model\Task\Queue\TaskQueueRepositoryInterface;
use Birgit\Component\Task\Queue\Type\TaskQueueTypeInterface;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;

/**
 * Task Queue Handler
 */
class TaskQueueHandler
{
    /**
     * Task Queue
     *
     * @var TaskQueue
     */
    protected $taskQueue;

    /**
     * Task Queue Type
     *
     * @var TaskQueueTypeInterface
     */
    protected $taskQueueType;

    /**
     * Task queue repository
     *
     * @var TaskQueueRepositoryInterface
     */
    protected $taskQueueRepository;

    /**
     * Constructor
     *
     * @param TaskQueue                    $taskQueue
     * @param TaskQueueTypeInterface       $taskQueueType
     * @param TaskQueueRepositoryInterface $taskQueueRepository
     */
    public function __construct(
        TaskQueue $taskQueue,
        TaskQueueTypeInterface $taskQueueType,
        TaskQueueRepositoryInterface $taskQueueRepository
    ) {
        // Task queue
        $this->taskQueue = $taskQueue;

        // Task queue type
        $this->taskQueueType = $taskQueueType;

        // Task queue repository
        $this->taskQueueRepository = $taskQueueRepository;
    }

    /**
     * Run
     *
     * @param TaskQueueContextInterface $context
     */
    public function run(TaskQueueContextInterface $context)
    {
        $this->taskQueueType->run(
            $this->taskQueue,
            $context
        );
    }

    /**
     * Push task
     *
     * @param Task $task
     *
     * @return TaskQueueHandler
     */
    public function pushTask(Task $task)
    {
        $this->taskQueueRepository
            ->addTaskQueueTask(
                $this->taskQueue,
                $task
            );

        return $this;
    }

    /**
     * Push predecessor
     *
     * @param TaskQueue $predecessor
     *
     * @return TaskQueueHandler
     */
    public function pushPredecessor(TaskQueue $predecessor)
    {
        $this->taskQueueRepository
            ->addTaskQueuePredecessor(
                $this->taskQueue,
                $predecessor
            );

        return $this;
    }

    /**
     * Push successor
     *
     * @param TaskQueue $successor
     *
     * @return TaskQueueHandler
     */
    public function pushSuccessor(TaskQueue $successor)
    {
        $this->taskQueueRepository
            ->addTaskQueueSuccessor(
                $this->taskQueue,
                $successor
            );

        return $this;
    }
}
