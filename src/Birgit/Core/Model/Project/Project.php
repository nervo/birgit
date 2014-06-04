<?php

namespace Birgit\Core\Model\Project;

use Birgit\Component\Type\Typeable;
use Birgit\Core\Model\Project\Reference\ProjectReference;
use Birgit\Core\Model\Project\Environment\ProjectEnvironment;

/**
 * Project
 */
abstract class Project implements Typeable
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this
            ->setStatus(
                new ProjectStatus(ProjectStatus::UNKNOWN)
            )
            ->setActive(true);
    }

    /**
     * Get name
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Set active
     *
     * @param bool $active
     *
     * @return Project
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
     * Set status
     *
     * @param ProjectStatus $status
     *
     * @return Project
     */
    abstract public function setStatus(ProjectStatus $status);

    /**
     * Get status
     *
     * @return ProjectStatus
     */
    abstract public function getStatus();

    /**
     * Add reference
     *
     * @param ProjectReference $reference
     *
     * @return Project
     */
    abstract public function addReference(ProjectReference $reference);

    /**
     * Remove reference
     *
     * @param ProjectReference $reference
     *
     * @return Project
     */
    abstract public function removeReference(ProjectReference $reference);

    /**
     * Get references
     *
     * @return \Traversable
     */
    abstract public function getReferences();

    /**
     * Add environment
     *
     * @param ProjectEnvironment $environment
     *
     * @return Project
     */
    abstract public function addEnvironment(ProjectEnvironment $environment);

    /**
     * Remove environment
     *
     * @param ProjectEnvironment $environment
     *
     * @return Project
     */
    abstract public function removeEnvironment(ProjectEnvironment $environment);

    /**
     * Get environments
     *
     * @return \Traversable
     */
    abstract public function getEnvironments();
}
