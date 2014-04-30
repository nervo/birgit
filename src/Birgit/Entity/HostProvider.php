<?php

namespace Birgit\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Host provider
 *
 * @ORM\Table(
 *     name="host_provider"
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\HostProviderRepository"
 * )
 */
class HostProvider
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
     * Project environments
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Project\Environment",
     *     mappedBy="hostProvider",
     *     cascade={"persist"}
     * )
     */
    private $projectEnvironments;

    /**
     * Constructor
     */
    public function __construct()
    {
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
     * @return HostProvider
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
     * @return HostProvider
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
     * Add project environment
     *
     * @param Project\Environment $projectEnvironment
     *
     * @return HostProvider
     */
    public function addProjectEnvironment(Project\Environment $projectEnvironment)
    {
        if (!$this->projectEnvironments->contains($projectEnvironment)) {
            $this->projectEnvironments->add($projectEnvironment);
            $projectEnvironment->setHostProvider($this);
        }

        return $this;
    }

    /**
     * Remove project environment
     *
     * @param Project\Environment $projectEnvironment
     *
     * @return HostProvider
     */
    public function removeProjectEnvironment(Project\Environment $projectEnvironment)
    {
        $this->projectEnvironments->removeElement($projectEnvironment);

        return $this;
    }

    /**
     * Get project environments
     *
     * @return Collection
     */
    public function getProjectEnvironments()
    {
        return $this->projectEnvironments;
    }
}
