<?php

namespace Birgit\Domain\Worker;

use Birgit\Core\Model\ModelManagerInterface;
use Birgit\Component\Handler\HandlerManager;
use Birgit\Component\Context\Context;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Component\Task\Model\Task\Queue\TaskQueueStatus;
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

    public function run(Context $context)
    {
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
                        $this->handlerManager
                            ->getTaskQueueHandler($taskQueueFound)
                                ->run($taskQueueFound, $context);

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
