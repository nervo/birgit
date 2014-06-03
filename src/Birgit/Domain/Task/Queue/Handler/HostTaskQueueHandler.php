<?php

namespace Birgit\Domain\Task\Queue\Handler;

use Birgit\Component\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Component\Context\ContextInterface;
use Birgit\Domain\Task\Queue\Context\HostTaskQueueContext;
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
