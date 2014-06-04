<?php

namespace Birgit\Core\Bundle\DoctrineBundle\Entity\Project;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Core\Model;
use Birgit\Component\Type\TypeDefinition;

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
    public function setStatus(Model\Project\ProjectStatus $status)
    {
        $this->status = $status->get();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return new Model\Project\ProjectStatus(
            $this->status
        );
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
     * Type Definition : Set alias
     *
     * @param string $alias
     *
     * @return Project
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
     * @return Project
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
     * @return Project
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
