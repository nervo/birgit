<?php

namespace Birgit\Core\Task\Queue\Context\Host;

use Birgit\Core\Task\Queue\Context\Project\Reference\ProjectReferenceTaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\Project\Environment\ProjectEnvironmentTaskQueueContextInterface;
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
