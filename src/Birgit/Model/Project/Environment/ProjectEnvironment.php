<?php

namespace Birgit\Model\Project\Environment;

use Doctrine\Common\Collections\Collection;

use Birgit\Model\Project\Project;
use Birgit\Model\Host\Provider\HostProvider;
use Birgit\Model\Host\Host;

/**
 * Project environment
 */
abstract class ProjectEnvironment
{
    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Repository reference pattern
     *
     * @var string
     */
    protected $repositoryReferencePattern;

    /**
     * Active
     *
     * @var bool
     */
    protected $active = true;

    /**
     * Project
     *
     * @var Project
     */
    protected $project;

    /**
     * Host provider
     *
     * @var HostProvider
     */
    protected $hostProvider;

    /**
     * Hosts
     *
     * @var Collection
     */
    protected $hosts;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ProjectEnvironment
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Set repository reference pattern
     *
     * @param string $pattern
     *
     * @return ProjectEnvironment
     */
    public function setRepositoryReferencePattern($pattern)
    {
        $this->repositoryReferencePattern = (string) $pattern;

        return $this;
    }

    /**
     * Get repository reference pattern
     *
     * @return string
     */
    public function getRepositoryReferencePattern()
    {
        return $this->repositoryReferencePattern;
    }

    /**
     * Set active
     *
     * @param bool $active
     *
     * @return ProjectEnvironment
     */
    public function setActive($active)
    {
        $this->active = (bool) $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set project
     *
     * @param Project $project
     *
     * @return ProjectEnvironment
     */
    public function setProject(Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set host provider
     *
     * @param HostProvider $hostProvider
     *
     * @return ProjectEnvironment
     */
    public function setHostProvider(HostProvider $hostProvider)
    {
        $this->hostProvider = $hostProvider;

        return $this;
    }

    /**
     * Get host provider
     *
     * @return HostProvider
     */
    public function getHostProvider()
    {
        return $this->hostProvider;
    }

    /**
     * Add host
     *
     * @param Host $host
     *
     * @return ProjectEnvironment
     */
    public function addHost(Host $host)
    {
        if (!$this->hosts->contains($host)) {
            $this->hosts->add($host);
            $host->setProjectEnvironment($this);
        }

        return $this;
    }

    /**
     * Remove host
     *
     * @param Host $host
     *
     * @return ProjectEnvironment
     */
    public function removeHost(Host $host)
    {
        $this->hosts->removeElement($host);

        return $this;
    }

    /**
     * Get hosts
     *
     * @return Collection
     */
    public function getHosts()
    {
        return $this->hosts;
    }
}
