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
            WorkflowEvents::PROJECT         => 'onWorkflowProject',
            ProjectEvents::STATUS_UP        => 'onProjectStatusUp',
            ProjectEvents::REFERENCE        => 'onProjectReference',
            ProjectEvents::REFERENCE_CREATE => 'onProjectReferenceCreate',
            ProjectEvents::REFERENCE_DELETE => 'onProjectReferenceDelete'
            
                
            //TaskEvents::TASK_QUEUE . '.' . 'project'                  => 'onProjectTaskQueue',
            //TaskEvents::TASK_QUEUE . '.' . 'project_reference'        => 'onProjectReferenceTaskQueue',
            //TaskEvents::TASK_QUEUE . '.' . 'project_reference_create' => 'onProjectReferenceCreateTaskQueue'
        );
    }

    public function onWorkflowProject(ProjectEvent $event)
    {
        // Get project
        $project = $event->getProject();

        // Task queue
        $this->runTaskQueue(
            'project', [
                'project_name' => $project->getName()
            ], [[
                'project_status'
            ]]
        );
    }
    
    public function onProjectStatusUp(ProjectEvent $event)
    {
        // Get project
        $project = $event->getProject();

        // Task queue
        $this->runTaskQueue(
            'project', [
                'project_name' => $project->getName()
            ], [[
                'project_references'
            ]]
        );
    }

    public function onProjectReference(ProjectReferenceEvent $event)
    {
        // Get project reference
        $projectReference = $event->getProjectReference();

        // Task queue
        $this->runTaskQueue(
            'project_reference', [
                'project_name'           => $projectReference->getProject()->getName(),
                'project_reference_name' => $projectReference->getName()
            ]
        );
    }

    public function onProjectReferenceCreate(ProjectReferenceEvent $event)
    {
        // Get project reference
        $projectReference = $event->getProjectReference();

        // Task queue
        $this->runTaskQueue(
            'project_reference_create', [
                'project_name'           => $projectReference->getProject()->getName(),
                'project_reference_name' => $projectReference->getName()
            ]
        );
    }

    public function onProjectReferenceDelete(ProjectReferenceEvent $event)
    {
        // Get project reference
        $projectReference = $event->getProjectReference();

        // Task queue
        $this->runTaskQueue(
            'project_reference_delete', [
                'project_name'           => $projectReference->getProject()->getName(),
                'project_reference_name' => $projectReference->getName()
            ]
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
    
    /**
     * Run task queue
     * 
     * @param array $parameters
     */
    protected function runTaskQueue($type, array $parameters = array(), $tasks = array())
    {
        // Create task queue
        $taskQueue = $this->modelManager
            ->getTaskQueueRepository()
            ->create(
                new HandlerDefinition(
                    (string) $type,
                    new Parameters($parameters)
                )
            );

        foreach ($tasks as $task) {
            // Add task
            $taskQueue
                ->addTask(
                    $this->modelManager
                        ->getTaskRepository()
                        ->create(
                            new HandlerDefinition(
                                (string) $task[0],
                                new Parameters(isset($task[1]) ? (array) $task[1] : array())
                            )
                        )
                );
        }

        // Run
        $this->handlerManager
            ->getTaskQueueHandler($taskQueue)
                ->run(
                    $taskQueue,
                    $this->context
                );
    }
}
