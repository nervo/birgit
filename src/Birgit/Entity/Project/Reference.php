<?php

namespace Birgit\Entity\Project;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Entity\Project;
use Birgit\Entity\Host;
use Birgit\Entity\Build;

/**
 * Project reference
 *
 * @ORM\Table(
 *     name="project_reference"
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\Project\ReferenceRepository"
 * )
 */
class Reference
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
     * Name
     *
     * @var string
     *
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=255
     * )
     */
    private $name;

    /**
     * Project
     *
     * @var Project
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Project",
     *     inversedBy="references"
     * )
     * @ORM\JoinColumn(
     *     name="project_id",
     *     nullable=false
     * )
     */
    private $project;

    /**
     * Hosts
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Host",
     *     mappedBy="projectReference",
     *     cascade={"persist"}
     * )
     */
    private $hosts;

    /**
     * Builds
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Build",
     *     mappedBy="projectReference",
     *     cascade={"persist"}
     * )
     */
    private $builds;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Hosts
        $this->hosts = new ArrayCollection();

        // Builds
        $this->builds = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Reference
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
     * Set project
     *
     * @param Project $project
     *
     * @return Reference
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
     * @return Reference
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
     * @return Reference
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
     * Add build
     *
     * @param Build $build
     *
     * @return Reference
     */
    public function addBuild(Build $build)
    {
        if (!$this->builds->contains($build)) {
            $this->builds->add($build);
            $build->setProjectReference($this);
        }

        return $this;
    }

    /**
     * Remove build
     *
     * @param Build $build
     *
     * @return Reference
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
