<?php

namespace Birgit\Core\Task\Queue\Context\Project;

use Birgit\Core\Model\Project\Project;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

/**
 * Project Task queue Context
 */
class ProjectTaskQueueContext implements ProjectTaskQueueContextInterface
{
    protected $project;

    public function __construct(
        Project $project,
        TaskQueueContextInterface $context
    ) {
        $this->project = $project;
        $this->context = $context;
    }

    public function getProject()
    {
        return $this->project;
    }
    
    public function getTaskQueue()
    {
        return $this->context->getTaskQueue();
    }

    public function getTaskManager()
    {
        return $this->context->getTaskManager();
    }

    public function getEventDispatcher()
    {
        return $this->context->getEventDispatcher();
    }

    public function getLogger()
    {
        return $this->context->getLogger();
    }
}
