<?php

namespace Birgit\Domain\Host\Task\Queue\Handler;

use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Context\ContextInterface;
use Birgit\Domain\Host\Task\Queue\Context\HostTaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;

/**
 * Host Task queue Handler
 */
class HostTaskQueueHandler extends TaskQueueHandler
{
    public function getType()
    {
        return 'host';
    }

    public function run(TaskQueue $taskQueue, ContextInterface $context)
    {
        // Get host
        $host = $this->modelManager
            ->getHostRepository()
            ->get(
                $taskQueue->getHandlerDefinition()->getParameters()->get('host_id')
            );

        parent::run(
            $taskQueue,
            new HostTaskQueueContext(
                $host,
                $taskQueue,
                $context
            )
        );
    }
}
