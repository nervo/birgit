<?php

namespace Birgit\Model\Project\Reference;

use Birgit\Model\Project\Project;
use Birgit\Model\Project\Reference\Revision\ProjectReferenceRevision;
use Birgit\Model\Host\Host;

/**
 * Project reference
 */
abstract class ProjectReference
{
    /**
     * Get name
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Get project
     *
     * @return Project
     */
    abstract public function getProject();

    /**
     * Add revision
     *
     * @param ProjectReferenceRevision $revision
     *
     * @return ProjectReference
     */
    abstract public function addRevision(ProjectReferenceRevision $revision);

    /**
     * Remove revision
     *
     * @param ProjectReferenceRevision $revision
     *
     * @return ProjectReference
     */
    abstract public function removeRevision(ProjectReferenceRevision $revision);

    /**
     * Get revisions
     *
     * @return \Traversable
     */
    abstract public function getRevisions();

    /**
     * Add host
     *
     * @param Host $host
     *
     * @return ProjectReference
     */
    abstract public function addHost(Host $host);

    /**
     * Remove host
     *
     * @param Host $host
     *
     * @return ProjectReference
     */
    abstract public function removeHost(Host $host);

    /**
     * Get hosts
     *
     * @return \Traversable
     */
    abstract public function getHosts();
}
