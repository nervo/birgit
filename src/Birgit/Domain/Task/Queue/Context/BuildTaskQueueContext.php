<?php

namespace Birgit\Domain\Task\Queue\Context;

use Birgit\Component\Task\Queue\Context\TaskQueueContext;
use Birgit\Component\Context\ContextInterface;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Core\Model\Build\Build;

/**
 * Build Task queue Context
 */
class BuildTaskQueueContext extends TaskQueueContext implements BuildTaskQueueContextInterface
{
    protected $build;

    public function __construct(
        Build $build,
        TaskQueue $taskQueue,
        ContextInterface $context
    ) {
        $this->build = $build;

        parent::__construct($taskQueue, $context);
    }

    public function getBuild()
    {
        return $this->build;
    }

    public function getHost()
    {
        return $this->getBuild()->getHost();
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
