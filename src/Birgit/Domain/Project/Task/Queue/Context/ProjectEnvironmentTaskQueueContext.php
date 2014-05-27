<?php

namespace Birgit\Domain\Project\Task\Queue\Context;

use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Project\Environment\ProjectEnvironment;
use Birgit\Domain\Context\ContextInterface;

/**
 * Project environment Task queue Context
 */
class ProjectEnvironmentTaskQueueContext extends TaskQueueContext implements ProjectEnvironmentTaskQueueContextInterface
{
    protected $projectEnvironment;

    public function __construct(
        ProjectEnvironment $projectEnvironment,
        TaskQueue $queue,
        ContextInterface $context
    ) {
        $this->projectEnvironment = $projectEnvironment;

        parent::__construct($queue, $context);
    }

    public function getProjectEnvironment()
    {
        return $this->projectEnvironment;
    }

    public function getProject()
    {
        return $this->getProjectEnvironment()->getProject();
    }
}
