<?php

namespace Birgit\Model\Project\Reference\Revision;

use Doctrine\Common\Collections\Collection;

use Birgit\Model\Project\Reference\ProjectReference;
use Birgit\Model\Build\Build;

/**
 * Project reference revision
 */
abstract class ProjectReferenceRevision
{
    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Reference
     *
     * @var ProjectReference
     */
    protected $reference;

    /**
     * Builds
     *
     * @var Collection
     */
    protected $builds;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ProjectReferenceRevision
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set reference
     *
     * @param ProjectReference $reference
     *
     * @return ProjectReferenceRevision
     */
    public function setReference(ProjectReference $reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return ProjectReference
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Add build
     *
     * @param Build $build
     *
     * @return ProjectReferenceRevision
     */
    public function addBuild(Build $build)
    {
        if (!$this->builds->contains($build)) {
            $this->builds->add($build);
            $build->setProjectReferenceRevision($this);
        }

        return $this;
    }

    /**
     * Remove build
     *
     * @param Build $build
     *
     * @return ProjectReferenceRevision
     */
    public function removeBuild(Build $build)
    {
        $this->builds->removeElement($build);

        return $this;
    }

    /**
     * Get builds
     *
     * @return Collection
     */
    public function getBuilds()
    {
        return $this->builds;
    }
}
