<?php

namespace Birgit\Domain\Project\Event;

use Symfony\Component\EventDispatcher\Event;

use Birgit\Core\Model\Project\Project;

/**
 * Project Event
 */
class ProjectEvent extends Event
{
    /**
     * Project
     *
     * @var Project
     */
    protected $project;

    /**
     * Constructor
     *
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        // Project
        $this->project = $project;
    }

    /**
     * Get project
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }
}
