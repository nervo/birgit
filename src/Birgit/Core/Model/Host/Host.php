<?php

namespace Birgit\Core\Model\Host;

use Birgit\Core\Model\Project\Environment\ProjectEnvironment;
use Birgit\Core\Model\Project\Reference\ProjectReference;
use Birgit\Core\Model\Build\Build;

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
