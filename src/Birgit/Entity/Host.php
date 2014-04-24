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
     * Project environment repository references
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Project\Environment\RepositoryReference",
     *     mappedBy="host",
     *     cascade={"persist"}
     * )
     */
    private $projectEnvironmentRepositoryReferences;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Project environment repository references
        $this->projectEnvironmentRepositoryReferences = new ArrayCollection();
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
     * Add project environment repository reference
     *
     * @param Project\Environment\RepositoryReference $projectEnvironmentRepositoryReference
     *
     * @return Host
     */
    public function addProjectEnvironmentRepositoryReference(Project\Environment\RepositoryReference $projectEnvironmentRepositoryReference)
    {
        if (!$this->projectEnvironmentRepositoryReferences->contains($projectEnvironmentRepositoryReference)) {
            $this->projectEnvironmentRepositoryReferences->add($projectEnvironmentRepositoryReference);
            $projectEnvironmentRepositoryReference->setHost($this);
        }

        return $this;
    }

    /**
     * Remove project environment repository reference
     *
     * @param Project\Environment\RepositoryReference $projectEnvironmentRepositoryReference
     *
     * @return Host
     */
    public function removeProjectEnvironmentRepositoryReference(Project\Environment\RepositoryReference $projectEnvironmentRepositoryReference)
    {
        $this->projectEnvironmentRepositoryReferences->removeElement($projectEnvironmentRepositoryReference);

        return $this;
    }

    /**
     * Get project environment repository references
     *
     * @return Collection
     */
    public function getProjectEnvironmentRepositoryReferences()
    {
        return $this->projectEnvironmentRepositoryReferences;
    }
}
