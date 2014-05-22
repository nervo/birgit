<?php

namespace Birgit\Model\Project;

use Birgit\Component\Type\TypeModel;
use Birgit\Model\Project\Reference\ProjectReference;
use Birgit\Model\Project\Environment\ProjectEnvironment;

/**
 * Project
 */
abstract class Project extends TypeModel
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // Status
        $this->setStatus(ProjectStatus::UNKNOWN);

        // Active
        $this->setActive(true);
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Project
     */
    abstract public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Set status
     *
     * @param int $status
     *
     * @return Project
     */
    abstract public function setStatus($status);

    /**
     * Get status
     *
     * @return bool
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
