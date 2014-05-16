<?php

namespace Birgit\Model\Project\Reference;

use Doctrine\Common\Collections\Collection;

use Birgit\Model\Project\Project;
use Birgit\Model\Project\Reference\Revision\ProjectReferenceRevision;
use Birgit\Model\Host\Host;

/**
 * Project reference
 */
abstract class ProjectReference
{
    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Project
     *
     * @var Project
     */
    protected $project;

    /**
     * Revisions
     *
     * @var Collection
     */
    protected $revisions;

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
     * @return ProjectReference
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
     * Set project
     *
     * @param Project $project
     *
     * @return ProjectReference
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
     * Add revision
     *
     * @param ProjectReferenceRevision $revision
     *
     * @return ProjectReference
     */
    public function addRevision(ProjectReferenceRevision $revision)
    {
        if (!$this->revisions->contains($revision)) {
            $this->revisions->add($revision);
            $revision->setReference($this);
        }

        return $this;
    }

    /**
     * Remove revision
     *
     * @param ProjectReferenceRevision $revision
     *
     * @return ProjectReference
     */
    public function removeRevision(ProjectReferenceRevision $revision)
    {
        $this->revisions->removeElement($revision);

        return $this;
    }

    /**
     * Get revisions
     *
     * @return Collection
     */
    public function getRevisions()
    {
        return $this->revisions;
    }

    /**
     * Add host
     *
     * @param Host $host
     *
     * @return ProjectReference
     */
    public function addHost(Host $host)
    {
        if (!$this->hosts->contains($host)) {
            $this->hosts->add($host);
            $host->setProjectReference($this);
        }

        return $this;
    }

    /**
     * Remove host
     *
     * @param Host $host
     *
     * @return ProjectReference
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
