<?php

namespace Birgit\Core\Task\Queue\Context;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

use Birgit\Component\Task\Queue\Context\TaskQueueContext;
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
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->build = $build;

        parent::__construct($taskQueue, $eventDispatcher, $logger);
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
