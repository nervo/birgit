<?php

namespace Birgit\Model\Project;

use Doctrine\Common\Collections\Collection;

use Birgit\Component\Type\TypeModel;
use Birgit\Model\Project\Reference\ProjectReference;
use Birgit\Model\Project\Environment\ProjectEnvironment;

/**
 * Project
 */
abstract class Project extends TypeModel
{
    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Status
     *
     * @var int
     */
    protected $status = ProjectStatus::UNKNOWN;

    /**
     * References
     *
     * @var Collection
     */
    protected $references;

    /**
     * Active
     *
     * @var bool
     */
    protected $active = true;

    /**
     * Environments
     *
     * @var Collection
     */
    protected $environments;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set status
     *
     * @param int $status
     *
     * @return Project
     */
    public function setStatus($status)
    {
        $this->status = (int) $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add reference
     *
     * @param ProjectReference $reference
     *
     * @return Project
     */
    public function addReference(ProjectReference $reference)
    {
        if (!$this->references->contains($reference)) {
            $this->references->add($reference);
            $reference->setProject($this);
        }

        return $this;
    }

    /**
     * Remove reference
     *
     * @param ProjectReference $reference
     *
     * @return Project
     */
    public function removeReference(ProjectReference $reference)
    {
        $this->references->removeElement($reference);

        return $this;
    }

    /**
     * Get references
     *
     * @return Collection
     */
    public function getReferences()
    {
        return $this->references;
    }

    /**
     * Set active
     *
     * @param bool $active
     *
     * @return Project
     */
    public function setActive($active)
    {
        $this->active = (bool) $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Add environment
     *
     * @param ProjectEnvironment $environment
     *
     * @return Project
     */
    public function addEnvironment(ProjectEnvironment $environment)
    {
        if (!$this->environments->contains($environment)) {
            $this->environments->add($environment);
            $environment->setProject($this);
        }

        return $this;
    }

    /**
     * Remove environment
     *
     * @param ProjectEnvironment $environment
     *
     * @return Project
     */
    public function removeEnvironment(ProjectEnvironment $environment)
    {
        $this->environments->removeElement($environment);

        return $this;
    }

    /**
     * Get environments
     *
     * @return Collection
     */
    public function getEnvironments()
    {
        return $this->environments;
    }
}
