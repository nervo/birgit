<?php

namespace Birgit\Entity\Project\Environment;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Entity\Project;
use Birgit\Entity\Host;
use Birgit\Entity\Build;

/**
 * Project environment repository reference
 *
 * @ORM\Table(
 *     name="project_environment_repository_reference",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="project_environment_id_name",columns={"project_environment_id", "name"})}
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\Project\Environment\RepositoryReferenceRepository"
 * )
 */
class RepositoryReference
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
     * Project environment
     *
     * @var Project\Environment
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Project\Environment",
     *     inversedBy="repositoryReferences"
     * )
     * @ORM\JoinColumn(
     *     name="project_environment_id",
     *     nullable=false
     * )
     */
    private $projectEnvironment;

    /**
     * Host
     *
     * @var Host
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Host",
     *     inversedBy="projectEnvironmentRepositoryReferences",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(
     *     name="host_id",
     *     nullable=false
     * )
     */
    private $host;

    /**
     * Builds
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Build",
     *     mappedBy="projectEnvironmentRepositoryReference",
     *     cascade={"persist"}
     * )
     */
    private $builds;

    /**
     * Constructor
     */
    public function __construct()
    {
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
     * @return RepositoryReference
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
     * Set project environment
     *
     * @param Project\Environment $projectEnvironment
     *
     * @return RepositoryReference
     */
    public function setProjectEnvironment(Project\Environment $projectEnvironment)
    {
        $this->projectEnvironment = $projectEnvironment;

        return $this;
    }

    /**
     * Get project environment
     *
     * @return Project\Environment
     */
    public function getProjectEnvironment()
    {
        return $this->projectEnvironment;
    }

    /**
     * Set host
     *
     * @param Host $host
     *
     * @return RepositoryReference
     */
    public function setHost(Host $host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return Host
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Add build
     *
     * @param Build $build
     *
     * @return RepositoryReference
     */
    public function addBuild(Build $build)
    {
        if (!$this->builds->contains($build)) {
            $this->builds->add($build);
            $build->setProjectEnvironmentRepositoryReference($this);
        }

        return $this;
    }

    /**
     * Remove build
     *
     * @param Build $build
     *
     * @return RepositoryReference
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
