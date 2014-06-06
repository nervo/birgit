<?php

namespace Birgit\Core\Project\Handler;

use Birgit\Core\Model\Project\Project;
use Birgit\Core\Model\Project\Reference\ProjectReference;
use Birgit\Core\Project\Type\ProjectTypeInterface;
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
     * Task Queue Context
     *
     * @var TaskQueueContextInterface
     */
    protected $taskQueueContext;

    /**
     * Constructor
     *
     * @param Project                   $project
     * @param ProjectTypeInterface      $projectType
     * @param TaskQueueContextInterface $taskQueueContext
     */
    public function __construct(
        Project $project,
        ProjectTypeInterface $projectType,
        TaskQueueContextInterface $taskQueueContext
    ) {
        // Project
        $this->project = $project;

        // Project type
        $this->projectType = $projectType;

        // Task queue context
        $this->taskQueueContext = $taskQueueContext;
    }

    /**
     * Is up
     *
     * @return boolean
     */
    public function isUp()
    {
        return $this->projectType->isUp(
            $this->project,
            $this->taskQueueContext
        );
    }

    /**
     * Get references
     *
     * @return array
     */
    public function getReferences()
    {
        return $this->projectType->getReferences(
            $this->project,
            $this->taskQueueContext
        );
    }

    /**
     * Get reference revision
     *
     * @param ProjectReference $projectReference
     *
     * @return string
     */
    public function getReferenceRevision(ProjectReference $projectReference)
    {
        return $this->projectType->getReferenceRevision(
            $projectReference,
            $this->taskQueueContext
        );
    }
}
