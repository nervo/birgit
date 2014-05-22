<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Project;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;

/**
 * Project
 */
class Project extends Model\Project\Project
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
     * Status
     *
     * @var int
     */
    private $status;

    /**
     * References
     *
     * @var ArrayCollection
     */
    private $references;

    /**
     * Active
     *
     * @var bool
     */
    private $active;

    /**
     * Environments
     *
     * @var ArrayCollection
     */
    private $environments;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // References
        $this->references = new ArrayCollection();

        // Environments
        $this->environments = new ArrayCollection();
        
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
    public function setStatus($status)
    {
        $this->status = (int) $status;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function addReference(Model\Project\Reference\ProjectReference $reference)
    {
        if (!$this->references->contains($reference)) {
            $this->references->add($reference);
            $reference->setProject($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeReference(Model\Project\Reference\ProjectReference $reference)
    {
        $this->references->removeElement($reference);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReferences()
    {
        return $this->references;
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
    public function addEnvironment(Model\Project\Environment\ProjectEnvironment $environment)
    {
        if (!$this->environments->contains($environment)) {
            $this->environments->add($environment);
            $environment->setProject($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeEnvironment(Model\Project\Environment\ProjectEnvironment $environment)
    {
        $this->environments->removeElement($environment);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvironments()
    {
        return $this->environments;
    }
}
