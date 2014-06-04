<?php

namespace Birgit\Core\Project\Event;

use Symfony\Component\EventDispatcher\Event;

use Birgit\Core\Model\Project\Reference\ProjectReference;

/**
 * Project Reference Event
 */
class ProjectReferenceEvent extends Event
{
    /**
     * Project Reference
     *
     * @var ProjectReference
     */
    protected $projectReference;

    /**
     * Constructor
     *
     * @param ProjectReference $projectReference
     */
    public function __construct(ProjectReference $projectReference)
    {
        // Project Reference
        $this->projectReference = $projectReference;
    }

    /**
     * Get project reference
     *
     * @return ProjectReference
     */
    public function getProjectReference()
    {
        return $this->projectReference;
    }
}
