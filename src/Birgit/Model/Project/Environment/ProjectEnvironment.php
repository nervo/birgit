<?php

namespace Birgit\Model\Project\Environment;

use Doctrine\Common\Collections\Collection;

use Birgit\Component\Type\TypeModel;
use Birgit\Model\Project\Project;
use Birgit\Model\Project\Reference\ProjectReference;
use Birgit\Model\Host\Host;

/**
 * Project environment
 */
abstract class ProjectEnvironment extends TypeModel
{
    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Reference pattern
     *
     * @var string
     */
    protected $referencePattern;

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
     * Set reference pattern
     *
     * @param string $pattern
     *
     * @return ProjectEnvironment
     */
    public function setReferencePattern($pattern)
    {
        $this->referencePattern = (string) $pattern;

        return $this;
    }

    /**
     * Get reference pattern
     *
     * @return string
     */
    public function getReferencePattern()
    {
        return $this->referencePattern;
    }

    /**
     * Match reference
     * 
     * @param ProjectReference $reference
     * 
     * @return bool
     */
    public function matchReference(ProjectReference $reference)
    {
        return fnmatch(
            $this->getReferencePattern(),
            $reference->getName()
        );
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
