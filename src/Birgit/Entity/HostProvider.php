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
     * Path
     *
     * @var string
     *
     * @ORM\Column(
     *     name="path",
     *     type="string",
     *     length=255
     * )
     */
    private $path;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Host",
     *     mappedBy="hostProvider",
     *     cascade={"persist"}
     * )
     */
    private $hosts;

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
     * Set path
     *
     * @param string $path
     *
     * @return Project
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Add host
     *
     * @param Host $host
     *
     * @return HostProvider
     */
    public function addHost(Host $host)
    {
        if (!$this->hosts->contains($host)) {
            $this->hosts->add($host);
            $host->setHostProvider($this);
        }

        return $this;
    }

    /**
     * Remove host
     *
     * @param Host $host
     *
     * @return HostProvider
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

    /**
     * Create host
     *
     * @param Project\Branch $projectBranch
     *
     * @return Host
     */
    public function createHost(Project\Branch $projectBranch)
    {
        $host = (new Host())
            ->setHostProvider($this)
            ->setProjectBranch($projectBranch);

        return $host;
    }
}
