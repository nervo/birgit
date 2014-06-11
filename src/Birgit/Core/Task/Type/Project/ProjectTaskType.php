<?php

namespace Birgit\Core\Task\Type\Project;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Core\Task\Queue\Context\Project\ProjectTaskQueueContextInterface;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;
use Birgit\Core\Task\Type\TaskType;

/**
 * Project Task type
 */
class ProjectTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof ProjectTaskQueueContextInterface) {
            throw new ContextTaskQueueException();
        }

        // Get project
        $project = $context->getProject();

        // Get project handler
        $this->projectManager
            ->handleProject($project)
            ->onProjectTask($task, $context);
    }
}
