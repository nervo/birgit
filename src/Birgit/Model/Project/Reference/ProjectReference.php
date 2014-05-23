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
     * Constructor
     *
     * @param string  $name
     * @param Project $project
     */
    public function __construct($name, Project $project)
    {
        $this
            ->setName($name)
            ->setProject($project);
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ProjectReference
     */
    abstract public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Set project
     *
     * @param Project $project
     *
     * @return ProjectReference
     */
    abstract public function setProject(Project $project);

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
