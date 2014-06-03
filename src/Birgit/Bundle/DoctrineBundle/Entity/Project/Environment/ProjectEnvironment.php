<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Project\Environment;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;
use Birgit\Component\Parameters\Parameters;
use Birgit\Component\Handler\HandlerDefinition;

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
     * @return ProjectEnvironment
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
     * Set project
     *
     * @param Project $project
     *
     * @return ProjectEnvironment
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

    /**
     * Handler Definition : Set type
     *
     * @param string $type
     *
     * @return ProjectEnvironment
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
     * @return ProjectEnvironment
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
     * @return ProjectEnvironment
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
        return new HandlerDefinition(
            $this->handlerType,
            $this->handlerParameters
        );
    }
}
