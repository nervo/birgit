<?php

namespace Birgit\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Entity\Project;

/**
 * Host
 *
 * @ORM\Table(
 *     name="host"
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\HostRepository"
 * )
 */
class Host
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
     * Project environment
     *
     * @var Project\Environment
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Project\Environment",
     *     inversedBy="hosts"
     * )
     * @ORM\JoinColumn(
     *     name="project_environment_id",
     *     nullable=false
     * )
     */
    private $projectEnvironment;

    /**
     * Repository reference
     *
     * @var Repository\Reference
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Repository\Reference",
     *     inversedBy="hosts"
     * )
     * @ORM\JoinColumn(
     *     name="repository_reference_id",
     *     nullable=false
     * )
     */
    private $projectEnvironment;
    
    /**
     * Builds
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Build",
     *     mappedBy="host",
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
     * Set project environment
     *
     * @param Project\Environment $projectEnvironment
     *
     * @return Host
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
     * Set repository reference
     *
     * @param Repository\Reference $projectEnvironment
     *
     * @return Host
     */
    public function setRepositoryReference(Repository\Reference $repositoryReference)
    {
        $this->repositoryReference = $repositoryReference;

        return $this;
    }

    /**
     * Get repository reference
     *
     * @return Repository\Reference
     */
    public function getRepositoryReference()
    {
        return $this->repositoryReference;
    }
    
    /**
     * Add build
     *
     * @param Build $build
     *
     * @return Host
     */
    public function addBuild(Build $build)
    {
        if (!$this->builds->contains($build)) {
            $this->builds->add($build);
            $build->setHost($this);
        }

        return $this;
    }

    /**
     * Remove build
     *
     * @param Build $build
     *
     * @return Host
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
