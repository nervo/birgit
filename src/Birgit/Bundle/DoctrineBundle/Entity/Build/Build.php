<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Build;

use Birgit\Model;

/**
 * Build
 */
class Build extends Model\Build\Build
{
    /**
     * Id
     *
     * @var string
     */
    private $id;

    /**
     * Host
     *
     * @var Model\Host\Host
     */
    private $host;

    /**
     * Project reference revision
     *
     * @var Model\Project\Reference\Revision\ProjectReferenceRevision
     */
    private $projectReferenceRevision;

    /**
     * {@inheritdoc}
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
    public function setHost(Model\Host\Host $host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set project reference revision
     *
     * @param ProjectReferenceRevisionn $projectReferenceRevision
     *
     * @return Build
     */
    public function setProjectReferenceRevision(Model\Project\Reference\Revision\ProjectReferenceRevision $projectReferenceRevision)
    {
        $this->projectReferenceRevision = $projectReferenceRevision;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectReferenceRevision()
    {
        return $this->projectReferenceRevision;
    }
}
