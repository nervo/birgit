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
     * @var int
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
