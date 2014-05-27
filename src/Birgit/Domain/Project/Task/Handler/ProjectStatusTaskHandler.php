<?php

namespace Birgit\Domain\Project\Task\Handler;

use Birgit\Domain\Task\Handler\TaskHandler;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Model\ModelManagerInterface;
use Birgit\Model\Task\Task;
use Birgit\Model\Project\ProjectStatus;
use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Domain\Project\Task\Queue\Context\ProjectTaskQueueContextInterface;
use Birgit\Domain\Project\ProjectEvents;
use Birgit\Domain\Project\Event\ProjectEvent;
use Birgit\Domain\Exception\Context\ContextException;

/**
 * Project - Status Task handler
 */
class ProjectStatusTaskHandler extends TaskHandler
{
    protected $modelManager;
    protected $handlerManager;

    public function __construct(
        ModelManagerInterface $modelManager,
        HandlerManager $handlerManager
    ) {
        $this->modelManager   = $modelManager;
        $this->handlerManager = $handlerManager;
    }

    public function getType()
    {
        return 'project_status';
    }

    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof ProjectTaskQueueContextInterface) {
            throw new ContextException();
        }

        // Get project
        $project = $context->getProject();

        // Get project handler
        $projectHandler = $this->handlerManager
            ->getProjectHandler($project);

        // Is project up ?
        $isUp = $projectHandler
            ->isUp($project, $context);

        // Compute status
        $status = $isUp ? ProjectStatus::UP : ProjectStatus::DOWN;

        // Update project status
        if ($project->getStatus() != $status) {
            
            $project->setStatus($status);

            $this->modelManager
                ->getProjectRepository()
                ->save($project);
        }
        
        // Dispatch event
        $context->getEventDispatcher()
            ->dispatch(
                $isUp ? ProjectEvents::PROJECT_STATUS_UP : ProjectEvents::PROJECT_STATUS_DOWN,
                new ProjectEvent($project)
            );
    }
}
