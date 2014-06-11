<?php

namespace Birgit\Core\Project\Handler;

use Birgit\Core\Model\Project\Project;
use Birgit\Core\Model\Project\Reference\ProjectReference;
use Birgit\Core\Project\Type\ProjectTypeInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

/**
 * Project Handler
 */
class ProjectHandler
{
    /**
     * Project
     *
     * @var Project
     */
    protected $project;

    /**
     * Project Type
     *
     * @var ProjectTypeInterface
     */
    protected $projectType;

    /**
     * Constructor
     *
     * @param Project                   $project
     * @param ProjectTypeInterface      $projectType
     */
    public function __construct(
        Project $project,
        ProjectTypeInterface $projectType
    ) {
        // Project
        $this->project = $project;

        // Project type
        $this->projectType = $projectType;
    }

    /**
     * Is up
     *
     * @param TaskQueueContextInterface $context
     *
     * @return boolean
     */
    public function isUp(TaskQueueContextInterface $context)
    {
        return $this->projectType
            ->isUp(
                $this->project,
                $context
            );
    }

    /**
     * Get references
     *
     * @param TaskQueueContextInterface $context
     *
     * @return array
     */
    public function getReferences(TaskQueueContextInterface $context)
    {
        return $this->projectType
            ->getReferences(
                $this->project,
                $context
            );
    }

    /**
     * Get reference revision
     *
     * @param ProjectReference          $projectReference
     * @param TaskQueueContextInterface $context
     *
     * @return string
     */
    public function getReferenceRevision(ProjectReference $projectReference, TaskQueueContextInterface $context)
    {
        return $this->projectType
            ->getReferenceRevision(
                $projectReference,
                $context
            );
    }

    /**
     * On project task
     * 
     * @param Task                      $task
     * @param TaskQueueContextInterface $context
     */
    public function onProjectTask(Task $task, TaskQueueContextInterface $context)
    {
        $this->projectType
            ->onProjectTask(
                $task,
                $context
            );
    }
}
