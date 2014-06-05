<?php

namespace Birgit\Core\Task\Queue\Type\Host;

use Birgit\Core\Task\Queue\Type\TaskQueueType;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\Host\HostTaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 * Host Task queue Type
 */
class HostTaskQueueType extends TaskQueueType
{
    public function getAlias()
    {
        return 'host';
    }

    public function run(TaskQueue $taskQueue, TaskQueueContextInterface $context)
    {
        // Get host
        $host = $this->modelRepositoryManager
            ->getHostRepository()
            ->get(
                $taskQueue->getTypeDefinition()->getParameter('host_id')
            );

        parent::run(
            $taskQueue,
            new HostTaskQueueContext(
                $host,
                $context
            )
        );
    }
}
