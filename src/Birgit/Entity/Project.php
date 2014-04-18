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
     *     length=255
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
     * Branches
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Project\Branch",
     *     mappedBy="project",
     *     cascade={"persist"}
     * )
     */
    private $branches;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Branches
        $this->branches = new ArrayCollection();
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
     * Add branch
     *
     * @param Project\Branch $branch
     *
     * @return Project
     */
    public function addBranch(Project\Branch $branch)
    {
        if (!$this->branches->contains($branch)) {
            $this->branches->add($branch);
            $branch->setProject($this);
        }

        return $this;
    }

    /**
     * Remove branch
     *
     * @param Project\Branch $branch
     *
     * @return Project
     */
    public function removeBranch(Project\Branch $branch)
    {
        $this->branches->removeElement($branch);

        return $this;
    }

    /**
     * Get branches
     *
     * @return Collection
     */
    public function getBranches()
    {
        return $this->branches;
    }
}
