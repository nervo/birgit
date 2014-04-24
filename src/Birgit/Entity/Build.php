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
     * Project reference
     *
     * @var Project\Reference
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Project\Reference",
     *     inversedBy="builds"
     * )
     * @ORM\JoinColumn(
     *     name="project_reference_id",
     *     nullable=false
     * )
     */
    private $projectReference;

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
     * Set project reference
     *
     * @param Project\Reference $projectReference
     *
     * @return Build
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

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return Reference
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
