<?php

namespace Birgit\Model\Repository\Reference\Revision;

use Doctrine\Common\Collections\Collection;

use Birgit\Model\Repository\Reference\RepositoryReference;
use Birgit\Model\Build\Build;

/**
 * Repository reference revision
 */
abstract class RepositoryReferenceRevision
{
    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Reference
     *
     * @var RepositoryReference
     */
    protected $reference;

    /**
     * Builds
     *
     * @var Collection
     */
    protected $builds;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return RepositoryReferenceRevision
     */
    public function setName($name)
    {
        $this->name = (string) $name;

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
     * Set reference
     *
     * @param RepositoryReference $reference
     *
     * @return RepositoryReferenceRevision
     */
    public function setReference(RepositoryReference $reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return RepositoryReference
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Add build
     *
     * @param Build $build
     *
     * @return RepositoryReferenceRevision
     */
    public function addBuild(Build $build)
    {
        if (!$this->builds->contains($build)) {
            $this->builds->add($build);
            $build->setRepositoryReferenceRevision($this);
        }

        return $this;
    }

    /**
     * Remove build
     *
     * @param Build $build
     *
     * @return RepositoryReferenceRevision
     */
    public function removeBuild(Build $build)
    {
        $this->builds->removeElement($build);

        return $this;
    }

    /**
     * Get builds
     *
     * @return Collection
     */
    public function getBuilds()
    {
        return $this->builds;
    }
}
