<?php

namespace Birgit\Model\Repository;

use Doctrine\Common\Collections\Collection;

use Birgit\Model\Type;
use Birgit\Model\Repository\Reference\RepositoryReference;
use Birgit\Model\Project\Project;

/**
 * Repository
 */
abstract class Repository extends Type
{
    /**
     * References
     *
     * @var Collection
     */
    protected $references;

    /**
     * @var Collection
     */
    protected $projects;

    /**
     * Add reference
     *
     * @param RepositoryReference $reference
     *
     * @return Repository
     */
    public function addReference(RepositoryReference $reference)
    {
        if (!$this->references->contains($reference)) {
            $this->references->add($reference);
            $reference->setRepository($this);
        }

        return $this;
    }

    /**
     * Remove reference
     *
     * @param RepositoryReference $reference
     *
     * @return Repository
     */
    public function removeReference(RepositoryReference $reference)
    {
        $this->references->removeElement($reference);

        return $this;
    }

    /**
     * Get references
     *
     * @return Collection
     */
    public function getReferences()
    {
        return $this->references;
    }

    /**
     * Add project
     *
     * @param Project $project
     *
     * @return Repository
     */
    public function addProject(Project $project)
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setRepository($this);
        }

        return $this;
    }

    /**
     * Remove project
     *
     * @param Project $project
     *
     * @return Repository
     */
    public function removeProject(Project $project)
    {
        $this->projects->removeElement($project);

        return $this;
    }

    /**
     * Get projects
     *
     * @return Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }
}
