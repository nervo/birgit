<?php

namespace Birgit\Component\Task\Queue\Type;

use Birgit\Component\Type\Type;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Component\Task\Event\TaskEvent;
use Birgit\Component\Task\TaskEvents;
use Birgit\Component\Task\Model\Task\TaskStatus;
use Birgit\Component\Task\Queue\Exception\SuspendTaskQueueException;
use Birgit\Component\Task\Model\Task\TasksIterator;

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
        // Create tasks iterator
        $tasks = new TasksIterator(
            $context->getTaskManager()->getTaskRepository(),
            $taskQueue
        );

        foreach ($tasks as $task) {

            // Update
            $task
                ->setStatus(new TaskStatus(TaskStatus::RUNNING))
                ->incrementAttempts();

            // Save
            $context->getTaskManager()
                ->getTaskRepository()
                ->save($task);

            // Log
            $context->getLogger()->notice(sprintf('> Task: "%s"', $task->getTypeDefinition()->getAlias()), $task->getTypeDefinition()->getParameters());

            try {
                // Run
                $context->getTaskManager()
                    ->handleTask($task)
                        ->run($context);

                // Update status
                $task
                    ->setStatus(new TaskStatus(TaskStatus::FINISHED));
            } catch (SuspendTaskQueueException $exception) {

                // Update status
                $task
                    ->setStatus(new TaskStatus(TaskStatus::PENDING));

                throw $exception;
            }

            // Save
            $context->getTaskManager()
                ->getTaskRepository()
                ->save($task);
        }
    }
}
