<?php

namespace Birgit\Core\Bundle\DoctrineBundle\Entity\Project\Reference;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Core\Model;

/**
 * Project reference
 */
class ProjectReference extends Model\Project\Reference\ProjectReference
{
    /**
     * Id
     *
     * @var int
     */
    private $id;

    /**
     * Name
     *
     * @var string
     */
    private $name;

    /**
     * Project
     *
     * @var Model\Project\Project
     */
    private $project;

    /**
     * Revisions
     *
     * @var ArrayCollection
     */
    private $revisions;

    /**
     * Hosts
     *
     * @var ArrayCollection
     */
    private $hosts;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Revisions
        $this->revisions = new ArrayCollection();

        // Hosts
        $this->hosts = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ProjectReference
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set project
     *
     * @param Project $project
     *
     * @return ProjectReference
     */
    public function setProject(Model\Project\Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * {@inheritdoc}
     */
    public function getRevision()
    {
        return $this->revisions->last();
    }

    /**
     * {@inheritdoc}
     */
    public function addRevision(Model\Project\Reference\Revision\ProjectReferenceRevision $revision)
    {
        if (!$this->revisions->contains($revision)) {
            $this->revisions->add($revision);
            $revision->setReference($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeRevision(Model\Project\Reference\Revision\ProjectReferenceRevision $revision)
    {
        $this->revisions->removeElement($revision);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRevisions()
    {
        return $this->revisions;
    }

    /**
     * {@inheritdoc}
     */
    public function addHost(Model\Host\Host $host)
    {
        if (!$this->hosts->contains($host)) {
            $this->hosts->add($host);
            $host->setProjectReference($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeHost(Model\Host\Host $host)
    {
        $this->hosts->removeElement($host);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHosts()
    {
        return $this->hosts;
    }
}
