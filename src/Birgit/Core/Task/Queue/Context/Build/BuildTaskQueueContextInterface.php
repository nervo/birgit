<?php

namespace Birgit\Core\Task\Queue\Context\Build;

use Birgit\Core\Task\Queue\Context\Host\HostTaskQueueContextInterface;
use Birgit\Core\Model\Build\Build;

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
