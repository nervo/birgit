<?php

namespace Birgit\Entity;

use Doctrine\ORM\Mapping as ORM;

use Birgit\Entity\Project;

/**
 * Build
 *
 * @ORM\Table(
 *     name="build"
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\BuildRepository"
 * )
 */
class Build
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
     * Project environment repository reference
     *
     * @var Project\Environment\RepositoryReference
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Project\Environment\RepositoryReference",
     *     inversedBy="builds"
     * )
     * @ORM\JoinColumn(
     *     name="project_environment_repository_reference_id",
     *     nullable=false
     * )
     */
    private $projectEnvironmentRepositoryReference;

    /**
     * Hash
     *
     * @var string
     *
     * @ORM\Column(
     *     name="hash",
     *     type="string",
     *     length=255
     * )
     */
    private $hash;

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
     * Set project environment repository reference
     *
     * @param Project\Environment\RepositoryReference $projectEnvironmentRepositoryReference
     *
     * @return Build
     */
    public function setProjectEnvironmentRepositoryReference(Project\Environment\RepositoryReference $projectEnvironmentRepositoryReference)
    {
        $this->projectEnvironmentRepositoryReference = $projectEnvironmentRepositoryReference;

        return $this;
    }

    /**
     * Get project environment repository reference
     *
     * @return Project\Environment\RepositoryReference
     */
    public function getProjectEnvironmentRepositoryReference()
    {
        return $this->projectEnvironmentRepositoryReference;
    }

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return Build
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }
}
