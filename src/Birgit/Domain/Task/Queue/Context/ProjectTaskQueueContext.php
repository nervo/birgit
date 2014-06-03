<?php

namespace Birgit\Domain\Task\Queue\Context;

use Birgit\Component\Task\Queue\Context\TaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Model\Project\Project;
use Birgit\Component\Context\ContextInterface;

/**
 * Project Task queue Context
 */
class ProjectTaskQueueContext extends TaskQueueContext implements ProjectTaskQueueContextInterface
{
    protected $project;

    public function __construct(
        Project $project,
        TaskQueue $taskQueue,
        ContextInterface $context
    ) {
        $this->project = $project;

        parent::__construct($taskQueue, $context);
    }

    public function getProject()
    {
        return $this->project;
    }
}
