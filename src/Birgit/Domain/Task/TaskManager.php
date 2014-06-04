<?php

namespace Birgit\Domain\Task;

use Birgit\Component\Task\TaskManager as BaseTaskManager;
use Birgit\Core\Model\Host\Host;
use Birgit\Core\Model\Build\Build;
use Birgit\Core\Model\Project\Project;
use Birgit\Core\Model\Project\Reference\ProjectReference;
use Birgit\Core\Model\Project\Reference\Revision\ProjectReferenceRevision;

/**
 * Task Manager
 */
class TaskManager extends BaseTaskManager
{
    /**
     * Create Host Task queue
     *
     * @param Host $host
     */
    public function createHostTaskQueue(Host $host, $tasks = array())
    {
        return $this->createTaskQueue(
            'host',
            array(
                'host_id' => $host->getId()
            ),
            $tasks
        );
    }

    /**
     * Create Build Task queue
     *
     * @param Build $build
     */
    public function createBuildTaskQueue(Build $build, $tasks = array())
    {
        return $this->createTaskQueue(
            'build',
            array(
                'build_id' => $build->getId()
            ),
            $tasks
        );
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
}
