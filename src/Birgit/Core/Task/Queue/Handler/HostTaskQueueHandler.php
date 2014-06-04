<?php

namespace Birgit\Core\Task\Queue\Handler;

use Birgit\Component\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\HostTaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 * Host Task queue Handler
 */
class HostTaskQueueHandler extends TaskQueueHandler
{
    public function getType()
    {
        return 'host';
    }

    public function run(TaskQueue $taskQueue, TaskQueueContextInterface $context)
    {
        // Get host
        $host = $this->modelManager
            ->getHostRepository()
            ->get(
                $taskQueue->getTypeDefinition()->getParameter('host_id')
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
