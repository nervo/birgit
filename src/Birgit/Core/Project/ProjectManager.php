<?php

namespace Birgit\Core\Project;

use Birgit\Core\Model\Project\Project;
use Birgit\Core\Model\Project\Environment\ProjectEnvironment;
use Birgit\Component\Type\TypeResolver;

/**
 * Project Manager
 */
class ProjectManager
{
    protected $projectTypeResolver;
    protected $projectEnvironmentTypeResolver;

    public function __construct(
        TypeResolver $projectTypeResolver,
        TypeResolver $projectEnvironmentTypeResolver
    ) {
        $this->projectTypeResolver = $projectTypeResolver;
        $this->projectEnvironmentTypeResolver = $projectEnvironmentTypeResolver;
    }

    public function handleProject(Project $project, TaskQueueContextInterface $context)
    {
        return new ProjectHandler(
            $project,
            $this->projectTypeResolver->resolve($project),
            $context
        );
    }

    public function handleProjectEnvironment(ProjectEnvironment $projectEnvironment, TaskQueueContextInterface $context)
    {
        return new ProjectEnvironmentHandler(
            $projectEnvironment,
            $this->projectEnvironmentTypeResolver->resolve($projectEnvironment),
            $context
        );
    }
}
