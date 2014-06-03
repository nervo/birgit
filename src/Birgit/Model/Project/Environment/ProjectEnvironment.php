<?php

namespace Birgit\Model\Project\Environment;

use Birgit\Component\Handler\Handleable;
use Birgit\Model\Project\Project;
use Birgit\Model\Project\Reference\ProjectReference;
use Birgit\Model\Host\Host;

/**
 * Project environment
 */
abstract class ProjectEnvironment implements Handleable
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this
            ->setActive(true);
    }

    /**
     * Get name
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Set reference pattern
     *
     * @param string $pattern
     *
     * @return ProjectEnvironment
     */
    abstract public function setReferencePattern($pattern);

    /**
     * Get reference pattern
     *
     * @return string
     */
    abstract public function getReferencePattern();

    /**
     * Match reference
     *
     * @param ProjectReference $reference
     *
     * @return bool
     */
    public function matchReference(ProjectReference $reference)
    {
        return fnmatch(
            $this->getReferencePattern(),
            $reference->getName()
        );
    }

    /**
     * Set active
     *
     * @param bool $active
     *
     * @return ProjectEnvironment
     */
    abstract public function setActive($active);

    /**
     * Get active
     *
     * @return bool
     */
    abstract public function getActive();

    /**
     * Is active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->getActive();
    }

    /**
     * Get project
     *
     * @return Project
     */
    abstract public function getProject();

    /**
     * Add host
     *
     * @param Host $host
     *
     * @return ProjectEnvironment
     */
    abstract public function addHost(Host $host);

    /**
     * Remove host
     *
     * @param Host $host
     *
     * @return ProjectEnvironment
     */
    abstract public function removeHost(Host $host);

    /**
     * Get hosts
     *
     * @return \Traversable
     */
    abstract public function getHosts();

}
