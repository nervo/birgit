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
     * Repository reference revision
     *
     * @var Repository\Reference\Revision
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Repository\Reference\Revision",
     *     inversedBy="builds"
     * )
     * @ORM\JoinColumn(
     *     nullable=false
     * )
     */
    private $repositoryReferenceRevision;

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
     * Set repository reference revision
     *
     * @param Repository\Reference\Revision $repositoryReferenceRevision
     *
     * @return Build
     */
    public function setRepositoryReferenceRevision(Repository\Reference\Revision $repositoryReferenceRevision)
    {
        $this->repositoryReferenceRevision = $repositoryReferenceRevision;

        return $this;
    }

    /**
     * Get repository reference revision
     *
     * @return Repository\Reference\Revision
     */
    public function getRepositoryReferenceRevision()
    {
        return $this->repositoryReferenceRevision;
    }
}
