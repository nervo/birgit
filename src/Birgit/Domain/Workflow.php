<?php

namespace Birgit\Domain\Project;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Birgit\Domain\Task\TaskEvents;
use Birgit\Domain\Task\Event\TaskQueueEvent;
use Birgit\Model\ModelManagerInterface;
use Birgit\Domain\Handler\HandlerDefinition;

/**
 * Workflow
 */
class Workflow implements EventSubscriberInterface
{
    protected $modelManager;

    public function __construct(
        ModelManagerInterface $modelManager
    ) {
        $this->modelManager = $modelManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            TaskEvents::TASK_QUEUE . '.' . 'project'                  => 'onProjectTaskQueue',
            TaskEvents::TASK_QUEUE . '.' . 'project_reference'        => 'onProjectReferenceTaskQueue',
            TaskEvents::TASK_QUEUE . '.' . 'project_reference_create' => 'onProjectReferenceCreateTaskQueue'
        );
    }

    public function onProjectTaskQueue(TaskQueueEvent $event)
    {
        // Get task queue
        $taskQueue = $event->getTaskQueue();

        $taskQueue
            ->addTask(
                $this->modelManager
                    ->getTaskRepository()
                    ->create(
                        new HandlerDefinition('project')
                    )
            );
    }

    public function onProjectReferenceTaskQueue(TaskQueueEvent $event)
    {
        // Get task queue
        $taskQueue = $event->getTaskQueue();

        $taskQueue
            ->addTask(
                $this->modelManager
                    ->getTaskRepository()
                    ->create(
                        new HandlerDefinition('project_reference')
                    )
            );
    }

    public function onProjectReferenceCreateTaskQueue(TaskQueueEvent $event)
    {
        // Get task queue
        $taskQueue = $event->getTaskQueue();

        $taskQueue
            ->addTask(
                $this->modelManager
                    ->getTaskRepository()
                    ->create(
                        new HandlerDefinition('project_reference_environments')
                    )
            );
    }
}
