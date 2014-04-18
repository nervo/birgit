<?php

namespace Birgit\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Host provider
 *
 * @ORM\Table(
 *     name="host_provider"
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\HostProviderRepository"
 * )
 */
class HostProvider
{
    /**
     * Id
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(
     *     name="id",
     *     type="integer"
     * )
     * @ORM\GeneratedValue(
     *     strategy="AUTO"
     * )
     */
    private $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Project",
     *     mappedBy="hostProvider",
     *     cascade={"persist"}
     * )
     */
    private $projects;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Projects
        $this->projects = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add project
     *
     * @param Project $project
     *
     * @return HostProvider
     */
    public function addProject(Project $project)
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setHostProvider($this);
        }

        return $this;
    }

    /**
     * Remove project
     *
     * @param Project $project
     *
     * @return HostProvider
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
