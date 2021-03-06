<?php

namespace Birgit\Core\Model\Project\Reference\Revision;

use Birgit\Core\Model\Project\Reference\ProjectReference;
use Birgit\Core\Model\Build\Build;

/**
 * Project reference revision
 */
abstract class ProjectReferenceRevision
{
    /**
     * Get name
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Get reference
     *
     * @return ProjectReference
     */
    abstract public function getReference();

    /**
     * Add build
     *
     * @param Build $build
     *
     * @return ProjectReferenceRevision
     */
    abstract public function addBuild(Build $build);

    /**
     * Remove build
     *
     * @param Build $build
     *
     * @return ProjectReferenceRevision
     */
    abstract public function removeBuild(Build $build);

    /**
     * Get builds
     *
     * @return \Traversable
     */
    abstract public function getBuilds();
}
