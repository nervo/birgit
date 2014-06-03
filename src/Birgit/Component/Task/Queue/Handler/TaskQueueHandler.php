<?php

namespace Birgit\Component\Task\Queue\Handler;

use Birgit\Component\Handler\Handler;
use Birgit\Domain\Context\ContextInterface;
use Birgit\Component\Handler\HandlerManager;
use Birgit\Model\ModelManagerInterface;
use Birgit\Component\Task\TaskManager;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Component\Task\Event\TaskQueueEvent;
use Birgit\Component\Task\TaskEvents;
use Birgit\Model\Task\TaskStatus;
use Birgit\Domain\Exception\Task\Queue\SuspendTaskQueueException;

/**
 * Task queue Handler
 */
abstract class TaskQueueHandler extends Handler implements TaskQueueHandlerInterface
{
    /**
     * Model Manager
     *
     * @var ModelManagerInterface
     */
    protected $modelManager;

    /**
     * Handler Manager
     *
     * @var HandlerManager
     */
    protected $handlerManager;

    /**
     * Task Manager
     *
     * @var TaskManager
     */
    protected $taskManager;

    /**
     * Constructor
     *
     * @param ModelManagerInterface $modelManager
     * @param HandlerManager        $handlerManager
     * @param TaskManager           $taskManager
     */
    public function __construct(
        ModelManagerInterface $modelManager,
        HandlerManager $handlerManager,
        TaskManager $taskManager
    ) {
        // Model manager
        $this->modelManager   = $modelManager;

        // Handler manager
        $this->handlerManager = $handlerManager;

        // Task manager
        $this->taskManager = $taskManager;
    }

    public function run(TaskQueue $taskQueue, ContextInterface $context)
    {
        // Log
        $context->getLogger()->notice(sprintf('Task Queue: "%s"', $taskQueue->getHandlerDefinition()->getType()), $taskQueue->getHandlerDefinition()->getParameters()->all());

        // Dispatch event
        $context->getEventDispatcher()
            ->dispatch(
                TaskEvents::TASK_QUEUE . '.' . $this->getType(),
                new TaskQueueEvent($taskQueue)
            );

        // Get task repository
        $taskRepository = $this->modelManager
            ->getTaskRepository();

        // Get tasks
        $tasks = $taskQueue->getTasks()->toArray();

        while ($tasks) {
            // Get task
            $task = array_pop($tasks);

            // Log
            $context->getLogger()->notice(sprintf('> Task: "%s"', $task->getHandlerDefinition()->getType()), $task->getHandlerDefinition()->getParameters()->all());

            // Update
            $task
                ->setStatus(new TaskStatus(TaskStatus::RUNNING))
                ->incrementAttempts();

            // Save
            $taskRepository
                ->save($task);

            try {
                // Run
                $this->handlerManager
                    ->getTaskHandler($task)
                        ->run($task, $context);

                // Delete
                $taskRepository
                    ->delete($task);
            } catch (SuspendTaskQueueException $exception) {

                // Log
                $context->getLogger()->notice(sprintf('! Task Queue Suspended: "%s"', $taskQueue->getHandlerDefinition()->getType()), $taskQueue->getHandlerDefinition()->getParameters()->all());

                // Update
                $task
                    ->setStatus(new TaskStatus(TaskStatus::PENDING));

                // Save
                $taskRepository
                    ->save($task);

                throw $exception;
            }
        }
    }
}
