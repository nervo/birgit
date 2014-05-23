<?php

namespace Birgit\Model\Project\Reference\Revision;

use Birgit\Model\Project\Reference\ProjectReference;
use Birgit\Model\Build\Build;

/**
 * Project reference revision
 */
abstract class ProjectReferenceRevision
{
    /**
     * Constructor
     *
     * @param string           $name
     * @param ProjectReference $reference
     */
    public function __construct(name, ProjectReference $reference)
    {
        $this
            ->setName($name)
            ->setReference($reference);
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ProjectReferenceRevision
     */
    abstract public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Set reference
     *
     * @param ProjectReference $reference
     *
     * @return ProjectReferenceRevision
     */
    abstract public function setReference(ProjectReference $reference);

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
