<?php

namespace Birgit\Core\Task\Type\Host;

use Birgit\Core\Task\Type\TaskType;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;

/**
 * Host - Delete Task Type
 */
class HostDeleteTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'host_delete';
    }

    /**
     * {@inheritdoc}
     */
    public function run(Task $task, TaskQueueContextInterface $context)
    {
    }
}
