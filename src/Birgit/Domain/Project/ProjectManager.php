<?php

namespace Birgit\Domain\Project;

use Birgit\Domain\Project\Handler\ProjectHandlerInterface;
use Birgit\Model\Project\Project;
use Birgit\Domain\Project\Environment\Handler\ProjectEnvironmentHandlerInterface;
use Birgit\Model\Project\Environment\ProjectEnvironment;
use Birgit\Component\Exception\Exception;

/**
 * Project Manager
 */
class ProjectManager
{
    /**
     * Project handlers
     *
     * @var array
     */
    protected $projectHandlers = array();

    /**
     * Project environment handlers
     *
     * @var array
     */
    protected $projectEnvironmentHandlers = array();

    public function addProjectHandler(ProjectHandlerInterface $handler)
    {
        $this->projectHandlers[] = $handler;

        return $this;
    }

    public function getProjectHandler(Project $project)
    {
        $type = $project->getType();

        foreach ($this->projectHandlers as $handler) {
            if ($handler->getType() === $type) {
                return $handler;
            }
        }

        throw new Exception(sprintf('Project handler type "%s" not found', $type));
    }

    public function addProjectEnvironmentHandler(ProjectEnvironmentHandlerInterface $handler)
    {
        $this->projectEnvironmentHandlers[] = $handler;

        return $this;
    }

    public function getProjectEnvironmentHandler(ProjectEnvironment $projectEnvironment)
    {
        $type = $projectEnvironment->getType();

        foreach ($this->projectEnvironmentHandlers as $handler) {
            if ($handler->getType() === $type) {
                return $handler;
            }
        }

        throw new Exception(sprintf('Project environment handler type "%s" not found', $type));
    }
}
