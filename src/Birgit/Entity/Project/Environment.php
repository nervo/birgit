<?php

namespace Birgit\Entity\Project;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Entity\Project;
use Birgit\Entity\Host;
use Birgit\Entity\HostProvider;

/**
 * Project environment
 *
 * @ORM\Table(
 *     name="project_environment",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="project_id_name",columns={"project_id", "name"})}
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\Project\EnvironmentRepository"
 * )
 */
class Environment
{
    /**
     * Id
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(
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
     *     inversedBy="environments"
     * )
     * @ORM\JoinColumn(
     *     nullable=false
     * )
     */
    private $project;

    /**
     * Repository reference pattern
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255
     * )
     */
    private $repositoryReferencePattern;

    /**
     * Host provider
     *
     * @var HostProvider
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\HostProvider",
     *     inversedBy="projects"
     * )
     * @ORM\JoinColumn(
     *     nullable=false
     * )
     */
    private $hostProvider;
    
    /**
     * Active
     *
     * @var bool
     *
     * @ORM\Column(
     *     type="boolean"
     * )
     */
    private $active = true;

    /**
     * Hosts
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Host",
     *     mappedBy="projectEnvironment",
     *     cascade={"persist"}
     * )
     */
    private $hosts;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // Hosts
        $this->hosts = new ArrayCollection();
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
     * @return Environment
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
     * @return Environment
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
     * Set repository reference pattern
     *
     * @param string $pattern
     *
     * @return Environment
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
     * Set host provider
     *
     * @param HostProvider $hostProvider
     *
     * @return Environment
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
     * Set active
     *
     * @param bool $active
     *
     * @return Environment
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
     * Add host
     *
     * @param Host $host
     *
     * @return Environment
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
     * @return Environment
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
