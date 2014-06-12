<?php

namespace Birgit\Core\Task\Type\Host;

use Birgit\Core\Task\Type\TaskType;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Core\Task\Queue\Context\Host\HostTaskQueueContextInterface;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;

/**
 * Host - Task Type
 */
class HostTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'host';
    }

    /**
     * {@inheritdoc}
     */
    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof HostTaskQueueContextInterface) {
            throw new ContextTaskQueueException();
        }

        // Get host
        $host = $context->getHost();

        // Handle
        $this->projectManager
            ->handleProjectEnvironment($host->getProjectEnvironment())
            ->onHostTask($task, $context);
    }
}
