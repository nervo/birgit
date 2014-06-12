<?php

namespace Birgit\Core\Task\Type\Host;

use Birgit\Core\Task\Type\TaskType;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;

/**
 * Host - Build Task Type
 */
class HostBuildTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'host_build';
    }

    /**
     * {@inheritdoc}
     */
    public function run(Task $task, TaskQueueContextInterface $context)
    {
    }
}
