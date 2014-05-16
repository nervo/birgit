<?php

namespace Birgit\Model\Build;

use Birgit\Model\Host\Host;
use Birgit\Model\Project\Reference\Revision\ProjectReferenceRevision;

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
     * Project reference revision
     *
     * @var ProjectReferenceRevision
     */
    protected $projectReferenceRevision;

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
     * Set project reference revision
     *
     * @param ProjectReferenceRevisionn $projectReferenceRevision
     *
     * @return Build
     */
    public function setProjectReferenceRevision(ProjectReferenceRevision $projectReferenceRevision)
    {
        $this->projectReferenceRevision = $projectReferenceRevision;

        return $this;
    }

    /**
     * Get project reference revision
     *
     * @return ProjectReferenceRevision
     */
    public function getProjectReferenceRevision()
    {
        return $this->projectReferenceRevision;
    }
}
