<?php

namespace Birgit\Domain\Host\Task\Queue\Context;

use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;
use Birgit\Domain\Project\Task\Queue\Context\ProjectEnvironmentTaskQueueContextInterface;
use Birgit\Model\Host\Host;

/**
 * Host Task queue Context Interface
 */
interface HostTaskQueueContextInterface extends ProjectReferenceTaskQueueContextInterface, ProjectEnvironmentTaskQueueContextInterface
{
    /**
     * Get host
     *
     * @return Host
     */
    public function getHost();
}
