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
     *     nullable=false
     * )
     */
    private $repository;

    /**
     * Environments
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Project\Environment",
     *     mappedBy="project",
     *     cascade={"persist"}
     * )
     */
    private $environments;

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
     * Constructor
     */
    public function __construct()
    {
        // Environments
        $this->environments = new ArrayCollection();
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
     * Add environment
     *
     * @param Project\Environment $environment
     *
     * @return Project
     */
    public function addEnvironment(Project\Environment $environment)
    {
        if (!$this->environments->contains($environment)) {
            $this->environments->add($environment);
            $environment->setProject($this);
        }

        return $this;
    }

    /**
     * Remove environment
     *
     * @param Project\Environment $environment
     *
     * @return Project
     */
    public function removeEnvironment(Project\Environment $environment)
    {
        $this->environments->removeElement($environment);

        return $this;
    }

    /**
     * Get environments
     *
     * @return Collection
     */
    public function getEnvironments()
    {
        return $this->environments;
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
