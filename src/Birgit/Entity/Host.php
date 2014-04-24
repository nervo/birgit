<?php

namespace Birgit\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * Host provider
     *
     * @var HostProvider
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\HostProvider",
     *     inversedBy="hosts"
     * )
     * @ORM\JoinColumn(
     *     name="host_provider_id",
     *     nullable=false
     * )
     */
    private $hostProvider;

    /**
     * Project reference
     *
     * @var Project\Reference
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Project\Reference",
     *     inversedBy="hosts"
     * )
     * @ORM\JoinColumn(
     *     name="project_reference_id",
     *     nullable=false
     * )
     */
    private $projectReference;

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
     * Set project reference
     *
     * @param Project\Reference $projectReference
     *
     * @return Host
     */
    public function setProjectReference(Project\Reference $projectReference)
    {
        $this->projectReference = $projectReference;

        return $this;
    }

    /**
     * Get project reference
     *
     * @return Project\Reference
     */
    public function getProjectReference()
    {
        return $this->projectReference;
    }
}
