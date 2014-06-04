<?php

namespace Birgit\Core\Model\Build;

use Birgit\Core\Model\Host\Host;
use Birgit\Core\Model\Project\Reference\Revision\ProjectReferenceRevision;

/**
 * Build
 */
abstract class Build
{
    /**
     * Get id
     *
     * @return string
     */
    abstract public function getId();

    /**
     * Get host
     *
     * @return Host
     */
    abstract public function getHost();

    /**
     * Get project reference revision
     *
     * @return ProjectReferenceRevision
     */
    abstract public function getProjectReferenceRevision();
}
