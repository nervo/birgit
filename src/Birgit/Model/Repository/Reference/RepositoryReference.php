<?php

namespace Birgit\Model\Repository\Reference;

use Doctrine\Common\Collections\Collection;

use Birgit\Model\Repository\Repository;
use Birgit\Model\Repository\Reference\Revision\RepositoryReferenceRevision;
use Birgit\Model\Host\Host;

/**
 * Repository reference
 */
abstract class RepositoryReference
{
    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Repository
     *
     * @var Repository
     */
    protected $repository;

    /**
     * Revisions
     *
     * @var Collection
     */
    protected $revisions;

    /**
     * Hosts
     *
     * @var Collection
     */
    protected $hosts;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return RepositoryReference
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
     * Set repository
     *
     * @param Repository $repository
     *
     * @return RepositoryReference
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
     * Add revision
     *
     * @param RepositoryReferenceRevision $revision
     *
     * @return RepositoryReference
     */
    public function addRevision(RepositoryReferenceRevision $revision)
    {
        if (!$this->revisions->contains($revision)) {
            $this->revisions->add($revision);
            $revision->setReference($this);
        }

        return $this;
    }

    /**
     * Remove revision
     *
     * @param RepositoryReferenceRevision $revision
     *
     * @return RepositoryReference
     */
    public function removeRevision(RepositoryReferenceRevision $revision)
    {
        $this->revisions->removeElement($revision);

        return $this;
    }

    /**
     * Get revisions
     *
     * @return Collection
     */
    public function getRevisions()
    {
        return $this->revisions;
    }

    /**
     * Add host
     *
     * @param Host $host
     *
     * @return RepositoryReference
     */
    public function addHost(Host $host)
    {
        if (!$this->hosts->contains($host)) {
            $this->hosts->add($host);
            $host->setRepositoryReference($this);
        }

        return $this;
    }

    /**
     * Remove host
     *
     * @param Host $host
     *
     * @return RepositoryReference
     */
    public function removeHost(Host $host)
    {
        $this->hosts->removeElement($host);

        return $this;
    }

    /**
     * Get hosts
     *
     * @return Collection
     */
    public function getHosts()
    {
        return $this->hosts;
    }
}
