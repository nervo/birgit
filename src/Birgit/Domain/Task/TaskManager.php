<?php

namespace Birgit\Domain\Task;

use Birgit\Model\ModelManagerInterface;
use Birgit\Domain\Handler\HandlerDefinition;
use Birgit\Component\Parameters\Parameters;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Project\Project;
use Birgit\Model\Project\Reference\ProjectReference;
use Birgit\Model\Project\Reference\Revision\ProjectReferenceRevision;

/**
 * Task Manager
 */
class TaskManager
{
    protected $modelManager;

    public function __construct(
        ModelManagerInterface $modelManager
    ) {
        $this->modelManager   = $modelManager;
    }

    /**
     * Create Project Task queue
     *
     * @param Project $project
     * @param array   $tasks
     */
    public function createProjectTaskQueue(Project $project, $tasks = array())
    {
        return $this->createTaskQueue(
            'project',
            array(
                'project_name' => $project->getName()
            ),
            $tasks
        );
    }

    /**
     * Create Project Reference Task queue
     *
     * @param ProjectReference $projectReference
     * @param array            $tasks
     */
    public function createProjectReferenceTaskQueue(ProjectReference $projectReference, $tasks = array())
    {
        return $this->createTaskQueue(
            'project_reference',
            array(
                'project_name'             => $projectReference->getProject()->getName(),
                'project_reference_name'   => $projectReference->getName()
            ),
            $tasks
        );
    }

    /**
     * Create Project Reference Revision Task queue
     *
     * @param ProjectReferenceRevision $projectReferenceRevision
     * @param array                    $tasks
     */
    public function createProjectReferenceRevisionTaskQueue(ProjectReferenceRevision $projectReferenceRevision, $tasks = array())
    {
        return $this->createTaskQueue(
            'project_reference_revision',
            array(
                'project_name'                    => $projectReferenceRevision->getReference()->getProject()->getName(),
                'project_reference_name'          => $projectReferenceRevision->getReference()->getName(),
                'project_reference_revision_name' => $projectReferenceRevision->getName()
            ),
            $tasks
        );
    }

    /**
     * Create task queue
     *
     * @param string $type
     * @param array  $parameters
     * @param array  $tasks
     */
    public function createTaskQueue($type, array $parameters = array(), $tasks = array())
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

        foreach ($tasks as $taskType => $taskParameters) {
            // Handle task type only
            if (is_numeric($taskType)) {
                $taskType = $taskParameters;
                $taskParameters = array();
            }
            // Add task
            $taskQueue
                ->addTask(
                    $this->modelManager
                        ->getTaskRepository()
                        ->create(
                            new HandlerDefinition(
                                (string) $taskType,
                                new Parameters((array) $taskParameters)
                            )
                        )
                );
        }

        return $taskQueue;
    }

    /**
     * Push Task queue
     *
     * @param TaskQueue $taskQueue
     */
    public function pushTaskQueue(TaskQueue $taskQueue)
    {
        $this->modelManager
            ->getTaskQueueRepository()
            ->save($taskQueue);
    }
}
