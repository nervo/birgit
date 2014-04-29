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
     *     type="integer"
     * )
     * @ORM\GeneratedValue(
     *     strategy="AUTO"
     * )
     */
    private $id;

    /**
     * Host
     *
     * @var Host
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Host",
     *     inversedBy="builds"
     * )
     * @ORM\JoinColumn(
     *     nullable=false
     * )
     */
    private $host;

    /**
     * Revision
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255
     * )
     */
    private $revision;

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
     * Set host
     *
     * @param Host $host
     *
     * @return Build
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
     * Set revision
     *
     * @param string $revision
     *
     * @return Build
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;

        return $this;
    }

    /**
     * Get revision
     *
     * @return string
     */
    public function getRevision()
    {
        return $this->revision;
    }
}
