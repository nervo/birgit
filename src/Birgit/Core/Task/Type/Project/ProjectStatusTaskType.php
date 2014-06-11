<?php

namespace Birgit\Core\Task\Type\Project;

use Birgit\Component\Task\Model\Task\Task;
use Birgit\Core\Model\Project\ProjectStatus;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\Project\ProjectTaskQueueContextInterface;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;
use Birgit\Core\Task\Type\TaskType;

/**
 * Project - Status Task type
 */
class ProjectStatusTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'project_status';
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

        // Is project up ?
        $isUp = $this->projectManager
            ->handleProject($project)
            ->isUp($context);

        // Compute status
        $status = $isUp ? ProjectStatus::UP : ProjectStatus::DOWN;

        // Update project status
        if (!$project->getStatus()->is($status)) {

            $project->setStatus(new ProjectStatus($status));

            $this->modelRepositoryManager
                ->getProjectRepository()
                ->save($project);
        }
    }
}
