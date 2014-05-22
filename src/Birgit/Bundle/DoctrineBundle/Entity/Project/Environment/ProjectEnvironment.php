<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Project\Environment;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;

/**
 * Project environment
 */
class ProjectEnvironment extends Model\Project\Environment\ProjectEnvironment
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
     * Reference pattern
     *
     * @var string
     */
    private $referencePattern;

    /**
     * Active
     *
     * @var bool
     */
    private $active;

    /**
     * Project
     *
     * @var Model\Project\Project
     */
    private $project;

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
        // Hosts
        $this->hosts = new ArrayCollection();
        
        parent::__construct();
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
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * {@inheritdoc}
     */
    public function setReferencePattern($pattern)
    {
        $this->referencePattern = (string) $pattern;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReferencePattern()
    {
        return $this->referencePattern;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setActive($active)
    {
        $this->active = (bool) $active;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * {@inheritdoc}
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
    public function addHost(Model\Host\Host $host)
    {
        if (!$this->hosts->contains($host)) {
            $this->hosts->add($host);
            $host->setProjectEnvironment($this);
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
     * Get hosts
     *
     * @return \Traversable
     */
    public function getHosts()
    {
        return $this->hosts;
    }
}
