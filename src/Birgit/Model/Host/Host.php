<?php

namespace Birgit\Model\Host;

use Birgit\Model\Project\Environment\ProjectEnvironment;
use Birgit\Model\Project\Reference\ProjectReference;
use Birgit\Model\Build\Build;

/**
 * Host
 */
abstract class Host
{
    /**
     * Constructor
     *
     * @param ProjectReference   $projectReference
     * @param ProjectEnvironment $projectEnvironment
     */
    public function __construct(ProjectReference $projectReference, ProjectEnvironment $projectEnvironment)
    {
        $this
            ->setProjectReference($projectReference)
            ->setProjectEnvironment($projectEnvironment);
    }

    /**
     * Set project reference
     *
     * @param ProjectReference $projectReference
     *
     * @return Host
     */
    abstract public function setProjectReference(ProjectReference $projectReference);

    /**
     * Get project reference
     *
     * @return ProjectReference
     */
    abstract public function getProjectReference();

    /**
     * Set project environment
     *
     * @param ProjectEnvironment $projectEnvironment
     *
     * @return Host
     */
    abstract public function setProjectEnvironment(ProjectEnvironment $projectEnvironment);

    /**
     * Get project environment
     *
     * @return ProjectEnvironment
     */
    abstract public function getProjectEnvironment();

    /**
     * Add build
     *
     * @param Build $build
     *
     * @return Host
     */
    abstract public function addBuild(Build $build);

    /**
     * Remove build
     *
     * @param Build $build
     *
     * @return Host
     */
    abstract public function removeBuild(Build $build);

    /**
     * Get builds
     *
     * @return \Traversable
     */
    abstract public function getBuilds();
}
