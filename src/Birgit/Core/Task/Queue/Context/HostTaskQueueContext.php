<?php

namespace Birgit\Core\Task\Queue\Context;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

use Birgit\Component\Task\Queue\Context\TaskQueueContext;
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
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->host = $host;

        parent::__construct($taskQueue, $eventDispatcher, $logger);
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
