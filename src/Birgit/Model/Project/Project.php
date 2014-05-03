<?php

namespace Birgit\Model\Project;

use Doctrine\Common\Collections\Collection;

use Birgit\Model\Repository\Repository;
use Birgit\Model\Project\Environment\ProjectEnvironment;

/**
 * Project
 */
abstract class Project
{
    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Active
     *
     * @var bool
     */
    protected $active = true;

    /**
     * Repository
     *
     * @var Repository
     */
    protected $repository;

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
     * Set repository
     *
     * @param Repository $repository
     *
     * @return Project
     */
    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Get repository
     *
     * @return Repository
     */
    public function getRepository()
    {
        return $this->repository;
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
