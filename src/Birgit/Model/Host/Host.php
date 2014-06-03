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
     * Get id
     *
     * @return string
     */
    abstract public function getId();

    /**
     * Get project reference
     *
     * @return ProjectReference
     */
    abstract public function getProjectReference();

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
