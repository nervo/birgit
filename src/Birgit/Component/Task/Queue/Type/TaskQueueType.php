<?php

namespace Birgit\Component\Task\Queue\Type;

use Birgit\Component\Type\Type;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Component\Task\Event\TaskQueueEvent;
use Birgit\Component\Task\TaskEvents;
use Birgit\Component\Task\Model\Task\TaskStatus;
use Birgit\Component\Task\Queue\Exception\SuspendTaskQueueException;

/**
 * Task Queue Type
 */
abstract class TaskQueueType extends Type implements TaskQueueTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function run(TaskQueue $taskQueue, TaskQueueContextInterface $context)
    {
        // Log
        $context->getLogger()->notice(sprintf('Task Queue: "%s"', $taskQueue->getTypeDefinition()->getAlias()), $taskQueue->getTypeDefinition()->getParameters());

        // Dispatch event
        $context->getEventDispatcher()
            ->dispatch(
                TaskEvents::TASK_QUEUE . '.' . $this->getAlias(),
                new TaskQueueEvent($taskQueue)
            );

        // Get tasks
        $tasks = $taskQueue->getTasks()->toArray();

        while ($tasks) {
            // Get task
            $task = array_pop($tasks);

            // Log
            $context->getLogger()->notice(sprintf('> Task: "%s"', $task->getTypeDefinition()->getAlias()), $task->getTypeDefinition()->getParameters());

            // Update
            $task
                ->setStatus(new TaskStatus(TaskStatus::RUNNING))
                ->incrementAttempts();

            try {
                // Run
                $context->getTaskManager()
                    ->handleTask($task, $context)
                        ->run();

                // Delete
                $taskRepository
                    ->delete($task);
            } catch (SuspendTaskQueueException $exception) {

                // Log
                $context->getLogger()->notice(sprintf('! Task Queue Suspended: "%s"', $taskQueue->getTypeDefinition()->getAlias()), $taskQueue->getTypeDefinition()->getParameters());

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
