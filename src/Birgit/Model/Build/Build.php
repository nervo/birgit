<?php

namespace Birgit\Model\Build;

use Birgit\Model\Host\Host;
use Birgit\Model\Repository\Reference\Revision\RepositoryReferenceRevision;

/**
 * Build
 */
abstract class Build
{
    /**
     * Host
     *
     * @var Host
     */
    protected $host;

    /**
     * Repository reference revision
     *
     * @var RepositoryReferenceRevision
     */
    protected $repositoryReferenceRevision;

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
     * @param RepositoryReferenceRevisionn $repositoryReferenceRevision
     *
     * @return Build
     */
    public function setRepositoryReferenceRevision(RepositoryReferenceRevision $repositoryReferenceRevision)
    {
        $this->repositoryReferenceRevision = $repositoryReferenceRevision;

        return $this;
    }

    /**
     * Get repository reference revision
     *
     * @return RepositoryReferenceRevision
     */
    public function getRepositoryReferenceRevision()
    {
        return $this->repositoryReferenceRevision;
    }
}
