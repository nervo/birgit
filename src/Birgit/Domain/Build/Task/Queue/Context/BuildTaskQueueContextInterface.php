<?php

namespace Birgit\Domain\Build\Task\Queue\Context;

use Birgit\Domain\Host\Task\Queue\Context\HostTaskQueueContextInterface;
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
