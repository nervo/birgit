<?php

namespace Birgit\Component\Task\Bundle\DoctrineBundle\Entity\Task;

use Birgit\Component\Task\Model;
use Birgit\Component\Type\TypeDefinition;

/**
 * Task
 */
class Task extends Model\Task\Task
{
    /**
     * Id
     *
     * @var string
     */
    private $id;

    /**
     * Status
     *
     * @var int
     */
    protected $status;

    /**
     * Attempts
     *
     * @var int
     */
    protected $attempts;

    /**
     * Queue
     *
     * @var Model\Task\Queue\TaskQueue
     */
    private $queue;

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
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus(Model\Task\TaskStatus $status)
    {
        $this->status = $status->get();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return new Model\Task\TaskStatus(
            $this->status
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setAttempts($attempts)
    {
        $this->attempts = (int) $attempts;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     * Set queue
     *
     * @param TaskQueue $queue
     *
     * @return Task
     */
    public function setQueue(Model\Task\Queue\TaskQueue $queue)
    {
        $this->queue = $queue;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * Type Definition : Set alias
     *
     * @param string $alias
     *
     * @return Task
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
     * @return Task
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
     * @return Task
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
