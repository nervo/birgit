<?php

namespace Birgit\Model\Host\Provider;

use Doctrine\Common\Collections\Collection;

use Birgit\Model\Type;
use Birgit\Model\Project\Environment\ProjectEnvironment;

/**
 * Host provider
 */
abstract class HostProvider extends Type
{
    /**
     * Project environments
     *
     * @var Collection
     */
    protected $projectEnvironments;

    /**
     * Add project environment
     *
     * @param ProjectEnvironment $projectEnvironment
     *
     * @return HostProvider
     */
    public function addProjectEnvironment(ProjectEnvironment $projectEnvironment)
    {
        if (!$this->projectEnvironments->contains($projectEnvironment)) {
            $this->projectEnvironments->add($projectEnvironment);
            $projectEnvironment->setHostProvider($this);
        }

        return $this;
    }

    /**
     * Remove project environment
     *
     * @param ProjectEnvironment $projectEnvironment
     *
     * @return HostProvider
     */
    public function removeProjectEnvironment(ProjectEnvironment $projectEnvironment)
    {
        $this->projectEnvironments->removeElement($projectEnvironment);

        return $this;
    }

    /**
     * Get project environments
     *
     * @return Collection
     */
    public function getProjectEnvironments()
    {
        return $this->projectEnvironments;
    }
}
