<?php

namespace Birgit\Core\Worker;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

use Birgit\Core\Model\ModelManagerInterface;
use Birgit\Component\Handler\HandlerManager;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Component\Task\Model\Task\Queue\TaskQueueStatus;
use Birgit\Component\Task\Queue\Context\TaskQueueContext;
use Birgit\Component\Task\Queue\Exception\SuspendTaskQueueException;

/**
 * Worker
 */
class Worker
{
    protected $modelManager;
    protected $handlerManager;

    public function __construct(
        ModelManagerInterface $modelManager,
        HandlerManager $handlerManager
    ) {
        $this->modelManager   = $modelManager;
        $this->handlerManager = $handlerManager;
    }

    public function run(
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        // Get task queue repository
        $taskQueueRepository = $this->modelManager
            ->getTaskQueueRepository();

        while (true) {
            foreach ($taskQueueRepository as $taskQueue) {

                $taskQueueFound = $this->findChildlessPendingTaskQueue($taskQueue);

                if ($taskQueueFound) {

                    // Update
                    $taskQueueFound
                        ->setStatus(new TaskQueueStatus(TaskQueueStatus::RUNNING))
                        ->incrementAttempts();

                    // Save
                    $taskQueueRepository
                        ->save($taskQueueFound);

                    // Run
                    try {

                        // Create Task Queue Context
                        $taskQueueContext = new TaskQueueContext(
                            $taskQueueFound,
                            $eventDispatcher,
                            $logger
                        );

                        $this->handlerManager
                            ->getTaskQueueHandler($taskQueueFound)
                                ->run($taskQueueFound, $taskQueueContext);

                        // Delete
                        $taskQueueRepository
                            ->delete($taskQueueFound);
                    } catch (SuspendTaskQueueException $exception) {
                        // Update
                        $taskQueueFound
                            ->setStatus(new TaskQueueStatus(TaskQueueStatus::PENDING));

                        // Save
                        $taskQueueRepository
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
