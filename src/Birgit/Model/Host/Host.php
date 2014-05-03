<?php

namespace Birgit\Model\Host;

use Doctrine\Common\Collections\Collection;

use Birgit\Model\Project\Environment\ProjectEnvironment;
use Birgit\Model\Repository\Reference\RepositoryReference;
use Birgit\Model\Build\Build;

/**
 * Host
 */
abstract class Host
{
    /**
     * Project environment
     *
     * @var ProjectEnvironment
     */
    protected $projectEnvironment;

    /**
     * Repository reference
     *
     * @var RepositoryReference
     */
    protected $repositoryReference;

    /**
     * Builds
     *
     * @var Collection
     */
    protected $builds;

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
     * Set repository reference
     *
     * @param RepositoryReference $repositoryReference
     *
     * @return Host
     */
    public function setRepositoryReference(RepositoryReference $repositoryReference)
    {
        $this->repositoryReference = $repositoryReference;

        return $this;
    }

    /**
     * Get repository reference
     *
     * @return RepositoryReference
     */
    public function getRepositoryReference()
    {
        return $this->repositoryReference;
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
