<?php

namespace Birgit\Domain\Host\Task\Queue\Context;

use Psr\Log\LoggerInterface;

use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Host\Host;

/**
 * Host Task queue Context
 */
class HostTaskQueueContext extends TaskQueueContext implements HostTaskQueueContextInterface
{
    protected $host;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(Host $host, TaskQueue $queue, LoggerInterface $logger)
    {
        $this->host = $host;

        parent::__construct($queue, $logger);
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
