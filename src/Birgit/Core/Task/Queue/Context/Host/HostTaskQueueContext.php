<?php

namespace Birgit\Core\Task\Queue\Context\Host;

use Birgit\Core\Task\Queue\Context\Project\ProjectReferenceTaskQueueContext;
use Birgit\Core\Model\Host\Host;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

/**
 * Host Task queue Context
 */
class HostTaskQueueContext extends ProjectReferenceTaskQueueContext implements HostTaskQueueContextInterface
{
    protected $host;

    public function __construct(
        Host $host,
        TaskQueueContextInterface $context
    ) {
        $this->host = $host;

        parent::__construct(
            $host->getProjectReference(),
            $context
        );
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getProjectEnvironment()
    {
        return $this->getHost()->getProjectEnvironment();
    }
}
