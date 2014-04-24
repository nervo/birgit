<?php

namespace Birgit\Entity\Project;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Entity\Project;
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
     *     inversedBy="environments"
     * )
     * @ORM\JoinColumn(
     *     name="project_id",
     *     nullable=false
     * )
     */
    private $project;

    /**
     * Repository references
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Project\Environment\RepositoryReference",
     *     mappedBy="projectEnvironment",
     *     cascade={"persist"}
     * )
     */
    private $repositoryReferences;

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
     *     name="host_provider_id",
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
     *     name="active",
     *     type="boolean"
     * )
     */
    private $active = true;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Repository references
        $this->repositoryReferences = new ArrayCollection();
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
     * Add repository reference
     *
     * @param Project\Environment\RepositoryReference $repositoryReference
     *
     * @return Environment
     */
    public function addRepositoryReference(Project\Environment\RepositoryReference $repositoryReference)
    {
        if (!$this->repositoryReferences->contains($repositoryReference)) {
            $this->repositoryReferences->add($repositoryReference);
            $repositoryReference->setEnvironment($this);
        }

        return $this;
    }

    /**
     * Remove repository reference
     *
     * @param Project\Environment\RepositoryReference $repositoryReference
     *
     * @return Environment
     */
    public function removeRepositoryReference(Project\Environment\RepositoryReference $repositoryReference)
    {
        $this->repositoryReferences->removeElement($repositoryReference);

        return $this;
    }

    /**
     * Get repository references
     *
     * @return Collection
     */
    public function getRepositoryReferences()
    {
        return $this->repositoryReferences;
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
}
