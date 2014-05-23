<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Project;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;
use Birgit\Component\Parameters\Parameters;
use Birgit\Component\Handler\HandlerDefinition;

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
     * Handler Definition : Type
     *
     * @var string
     */
    protected $handlerType;

    /**
     * Handler Definition : Parameters
     *
     * @var Parameters
     */
    protected $handlerParameters;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        // References
        $this->references = new ArrayCollection();

        // Environments
        $this->environments = new ArrayCollection();
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
     * @return Project
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

    /**
     * Handler Definition : Set type
     *
     * @param string $type
     *
     * @return Project
     */
    public function setHandlerType($type)
    {
        $this->handlerType = (string) $type;

        return $this;
    }

    /**
     * Handler Definition : Get type
     *
     * @return string
     */
    public function getHandlerType()
    {
        return $this->handlerType;
    }

    /**
     * Handler Definition : Set parameters
     *
     * @param Parameters $parameters
     *
     * @return Project
     */
    public function setHandlerParameters(Parameters $parameters)
    {
        $this->handlerParameters = $parameters;

        return $this;
    }

    /**
     * Handler Definition : Get parameters
     *
     * @return Parameters
     */
    public function getHandlerParameters()
    {
        return $this->handlerParameters;
    }

    /**
     * Set Handler Definition
     *
     * @param HandlerDefinition $handlerDefinition
     *
     * @return Project
     */
    public function setHandlerDefinition(HandlerDefinition $handlerDefinition)
    {
        $this->handlerType       = $handlerDefinition->getType();
        $this->handlerParameters = $handlerDefinition->getParameters();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandlerDefinition()
    {
        $handlerDefinition = new HandlerDefinition();

        $handlerDefinition
            ->setType($this->handlerType)
            ->setParameters($this->handlerParameters);

        return $handlerDefinition;
    }
}
