<?php

namespace Birgit\Domain\Task\Queue\Context;

use Birgit\Model\Build\Build;

/**
 * Build Task queue Context Interface
 */
interface BuildTaskQueueContextInterface extends HostTaskQueueContextInterface
{
    /**
     * Get build
     *
     * @return Build
     */
    public function getBuild();
}
