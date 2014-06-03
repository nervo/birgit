<?php

namespace Birgit\Domain\Task\Queue\Context;

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
