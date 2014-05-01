<?php

namespace Birgit\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Repository
 *
 * @ORM\Table(
 *     name="repository"
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\RepositoryRepository"
 * )
 */
class Repository
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
     * Type
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255
     * )
     */
    private $type;

    /**
     * Parameters
     *
     * @var array
     *
     * @ORM\Column(
     *     type="json_array"
     * )
     */
    private $parameters;

    /**
     * References
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Repository\Reference",
     *     mappedBy="repository",
     *     cascade={"persist"}
     * )
     */
    private $references;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Project",
     *     mappedBy="repository",
     *     cascade={"persist"}
     * )
     */
    private $projects;

    /**
     * Constructor
     */
    public function __construct()
    {
        // References
        $this->references = new ArrayCollection();

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
     * Set type
     *
     * @param string $type
     *
     * @return Repository
     */
    public function setType($type)
    {
        $this->type = (string) $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set parameters
     *
     * @param array $parameters
     *
     * @return Repository
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Add reference
     *
     * @param Repository\Reference $reference
     *
     * @return Repository
     */
    public function addReference(Repository\Reference $reference)
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
     * @param Repository\Reference $reference
     *
     * @return Repository
     */
    public function removeReference(Repository\Reference $reference)
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
