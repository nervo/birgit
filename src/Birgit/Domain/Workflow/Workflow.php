<?php

namespace Birgit\Domain\Workflow;

use Psr\Log\LoggerInterface;
 
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Birgit\Domain\Task\TaskEvents;
use Birgit\Domain\Project\ProjectEvents;
use Birgit\Domain\Task\Event\TaskQueueEvent;
use Birgit\Model\ModelManagerInterface;
use Birgit\Domain\Handler\HandlerDefinition;
use Birgit\Domain\Project\Event\ProjectEvent;
use Birgit\Domain\Workflow\WorkflowEvents;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Component\Parameters\Parameters;
use Birgit\Domain\Context\Context;

/**
 * Workflow
 */
class Workflow implements EventSubscriberInterface
{
    protected $modelManager;
    protected $handlerManager;
    protected $context;

    public function __construct(
        ModelManagerInterface $modelManager,
        HandlerManager $handlerManager,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->modelManager   = $modelManager;
        $this->handlerManager = $handlerManager;
        
        $this->context = new Context(
            $eventDispatcher,
            $logger
        );
    }

    public static function getSubscribedEvents()
    {
        return array(
            WorkflowEvents::PROJECT => 'onWorkflowProject',
            ProjectEvents::STATUS_UP => 'onProjectStatusUp'
            //TaskEvents::TASK_QUEUE . '.' . 'project'                  => 'onProjectTaskQueue',
            //TaskEvents::TASK_QUEUE . '.' . 'project_reference'        => 'onProjectReferenceTaskQueue',
            //TaskEvents::TASK_QUEUE . '.' . 'project_reference_create' => 'onProjectReferenceCreateTaskQueue'
        );
    }

    public function onWorkflowProject(ProjectEvent $event)
    {
        // Get project
        $project = $event->getProject();

        // Create task queue
        $taskQueue = $this->modelManager
            ->getTaskQueueRepository()
            ->create(
                new HandlerDefinition(
                    'project',
                    new Parameters(array(
                        'project_name' => $project->getName()
                    ))
                )
            );

        // Add task
        $taskQueue
            ->addTask(
                $this->modelManager
                    ->getTaskRepository()
                    ->create(
                        new HandlerDefinition(
                            'project_status'
                        )
                    )
            );

        $this->handlerManager
            ->getTaskQueueHandler($taskQueue)
                ->run(
                    $taskQueue,
                    $this->context
                );
    }
    
    public function onProjectStatusUp(ProjectEvent $event)
    {
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
