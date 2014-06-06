<?php

namespace Birgit\Core\Task\Queue\Context\Host;

use Birgit\Core\Task\Queue\Context\Project\ProjectReferenceTaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\Project\ProjectEnvironmentTaskQueueContextInterface;
use Birgit\Core\Model\Host\Host;

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
