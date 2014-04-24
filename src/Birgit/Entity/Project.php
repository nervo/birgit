<?php

namespace Birgit\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Project
 *
 * @ORM\Table(
 *     name="project"
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\ProjectRepository"
 * )
 */
class Project
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
     *     length=255,
     *     unique=true
     * )
     */
    private $name;

    /**
     * Repository
     *
     * @var Repository
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Repository",
     *     inversedBy="projects"
     * )
     * @ORM\JoinColumn(
     *     name="repository_id",
     *     nullable=false
     * )
     */
    private $repository;

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
     * References
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Project\Reference",
     *     mappedBy="project",
     *     cascade={"persist"}
     * )
     */
    private $references;

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
        // References
        $this->references = new ArrayCollection();
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
     * @return Project
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
     * Set repository
     *
     * @param Repository $repository
     *
     * @return Project
     */
    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Get repository
     *
     * @return Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Set host provider
     *
     * @param HostProvider $hostProvider
     *
     * @return Project
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
     * Add reference
     *
     * @param Project\Reference $reference
     *
     * @return Project
     */
    public function addReference(Project\Reference $reference)
    {
        if (!$this->references->contains($reference)) {
            $this->references->add($reference);
            $reference->setProject($this);
        }

        return $this;
    }

    /**
     * Remove reference
     *
     * @param Project\Reference $reference
     *
     * @return Project
     */
    public function removeReference(Project\Reference $reference)
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
     * Set active
     *
     * @param bool $active
     *
     * @return Project
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
