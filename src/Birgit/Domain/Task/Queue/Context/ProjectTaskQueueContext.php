<?php

namespace Birgit\Domain\Task\Queue\Context;

use Birgit\Component\Task\Queue\Context\TaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Project\Project;
use Birgit\Domain\Context\ContextInterface;

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
