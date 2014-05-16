<?php

namespace Birgit\Model\Host;

use Doctrine\Common\Collections\Collection;

use Birgit\Model\Project\Environment\ProjectEnvironment;
use Birgit\Model\Project\Reference\ProjectReference;
use Birgit\Model\Build\Build;

/**
 * Host
 */
abstract class Host
{
    /**
     * Project reference
     *
     * @var ProjectReference
     */
    protected $projectReference;

    /**
     * Project environment
     *
     * @var ProjectEnvironment
     */
    protected $projectEnvironment;

    /**
     * Builds
     *
     * @var Collection
     */
    protected $builds;

    /**
     * Set project reference
     *
     * @param ProjectReference $projectReference
     *
     * @return Host
     */
    public function setProjectReference(ProjectReference $projectReference)
    {
        $this->projectReference = $projectReference;

        return $this;
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

    /**
     * Set project environment
     *
     * @param ProjectEnvironment $projectEnvironment
     *
     * @return Host
     */
    public function setProjectEnvironment(ProjectEnvironment $projectEnvironment)
    {
        $this->projectEnvironment = $projectEnvironment;

        return $this;
    }

    /**
     * Get project environment
     *
     * @return ProjectEnvironment
     */
    public function getProjectEnvironment()
    {
        return $this->projectEnvironment;
    }

    /**
     * Add build
     *
     * @param Build $build
     *
     * @return Host
     */
    public function addBuild(Build $build)
    {
        if (!$this->builds->contains($build)) {
            $this->builds->add($build);
            $build->setHost($this);
        }

        return $this;
    }

    /**
     * Remove build
     *
     * @param Build $build
     *
     * @return Host
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
