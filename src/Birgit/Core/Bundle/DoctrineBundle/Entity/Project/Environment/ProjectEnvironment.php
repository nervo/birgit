<?php

namespace Birgit\Core\Bundle\DoctrineBundle\Entity\Project\Environment;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Core\Model;
use Birgit\Component\Type\TypeDefinition;

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
     * Type Definition : Alias
     *
     * @var string
     */
    protected $typeAlias;

    /**
     * Type Definition : Parameters
     *
     * @var array
     */
    protected $typeParameters;

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
     * Type Definition : Set alias
     *
     * @param string $alias
     *
     * @return ProjectEnvironment
     */
    public function setTypeAlias($alias)
    {
        $this->typeAlias = (string) $alias;

        return $this;
    }

    /**
     * Type Definition : Get alias
     *
     * @return string
     */
    public function getTypeAlias()
    {
        return $this->typeAlias;
    }

    /**
     * Type Definition : Set parameters
     *
     * @param array $parameters
     *
     * @return ProjectEnvironment
     */
    public function setTypeParameters(array $parameters)
    {
        $this->typeParameters = $parameters;

        return $this;
    }

    /**
     * Type Definition : Get parameters
     *
     * @return array
     */
    public function getTypeParameters()
    {
        return $this->typeParameters;
    }

   /**
     * Set Type Definition
     *
     * @param TypeDefinition $typeDefinition
     *
     * @return ProjectEnvironment
     */
    public function setTypeDefinition(TypeDefinition $typeDefinition)
    {
        $this->typeAlias      = $typeDefinition->getAlias();
        $this->typeParameters = $typeDefinition->getParameters();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTypeDefinition()
    {
        return new TypeDefinition(
            $this->typeAlias,
            $this->typeParameters
        );
    }
}
