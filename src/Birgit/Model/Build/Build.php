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
     * Constructor
     *
     * @param Host $host
     */
    public function __construct(Host $host)
    {
        $this
            ->setHost($host);
    }

    /**
     * Set host
     *
     * @param Host $host
     *
     * @return Build
     */
    abstract public function setHost(Host $host);

    /**
     * Get host
     *
     * @return Host
     */
    abstract public function getHost();

    /**
     * Set project reference revision
     *
     * @param ProjectReferenceRevisionn $projectReferenceRevision
     *
     * @return Build
     */
    abstract public function setProjectReferenceRevision(ProjectReferenceRevision $projectReferenceRevision);

    /**
     * Get project reference revision
     *
     * @return ProjectReferenceRevision
     */
    abstract public function getProjectReferenceRevision();
}
