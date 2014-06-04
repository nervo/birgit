<?php

namespace Birgit\Domain\Task\Queue\Context;

use Birgit\Component\Task\Queue\Context\TaskQueueContext;
use Birgit\Component\Context\ContextInterface;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Core\Model\Host\Host;

/**
 * Host Task queue Context
 */
class HostTaskQueueContext extends TaskQueueContext implements HostTaskQueueContextInterface
{
    protected $host;

    public function __construct(
        Host $host,
        TaskQueue $taskQueue,
        ContextInterface $context
    ) {
        $this->host = $host;

        parent::__construct($taskQueue, $context);
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getProjectReference()
    {
        return $this->getHost()->getProjectReference();
    }

    public function getProject()
    {
        return $this->getProjectReference()->getProject();
    }

    public function getProjectEnvironment()
    {
        return $this->getHost()->getProjectEnvironment();
    }
}
