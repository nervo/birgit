<?php

namespace Birgit\Domain\Task\Handler\Host;

use Birgit\Component\Task\Handler\TaskHandler;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;

/**
 * Host - Delete Task Handler
 */
class HostDeleteTaskHandler extends TaskHandler
{
    /**
     * {@inheritdoc}
     */
    public function getType()
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
