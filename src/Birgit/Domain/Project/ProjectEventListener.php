<?php

namespace Birgit\Domain\Project;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Birgit\Domain\Task\TaskEvents;
use Birgit\Domain\Task\Event\TaskQueueEvent;
use Birgit\Domain\Task\TaskManager;

/**
 * Project EventListener
 */
class ProjectEventListener implements EventSubscriberInterface
{
    protected $projectManager;
    protected $taskManager;

    public function __construct(ProjectManager $projectManager, TaskManager $taskManager)
    {
        $this->projectManager = $projectManager;
        $this->taskManager    = $taskManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            TaskEvents::TASK_QUEUE . '.' . 'project_reference_create' => 'onProjectReferenceCreate'
        );
    }

    public function onProjectReferenceCreate(TaskQueueEvent $event)
    {
        // Get task queue
        $taskQueue = $event->getTaskQueue();
        
        $taskQueue
            ->addTask(
                $this->taskManager->createTask(
                    'project_reference_check'
                )
            );
    }
}
