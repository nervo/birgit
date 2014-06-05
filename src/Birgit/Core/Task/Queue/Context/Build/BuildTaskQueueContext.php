<?php

namespace Birgit\Core\Task\Queue\Context\Build;

use Birgit\Core\Task\Queue\Context\Host\HostTaskQueueContext;
use Birgit\Core\Model\Build\Build;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

/**
 * Build Task queue Context
 */
class BuildTaskQueueContext extends HostTaskQueueContext implements BuildTaskQueueContextInterface
{
    protected $build;

    public function __construct(
        Build $build,
        TaskQueueContextInterface $context
    ) {
        $this->build = $build;

        parent::__construct(
            $build->getHost(),
            $context
        );
    }

    public function getBuild()
    {
        return $this->build;
    }
}
