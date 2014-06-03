<?php

namespace Birgit\Bundle\TaskDoctrineBundle\Entity\Task;

use Birgit\Model;
use Birgit\Component\Parameters\Parameters;
use Birgit\Component\Handler\HandlerDefinition;

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
     * Handler Definition : Set type
     *
     * @param string $type
     *
     * @return Task
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
     * @return Task
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
     * @return Task
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
