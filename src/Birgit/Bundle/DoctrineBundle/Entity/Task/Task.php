<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Task;

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
     * @var int
     */
    private $id;

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
     * {@inheritdoc}
     */
    public function setHandlerDefinition(HandlerDefinition $handlerDefinition)
    {
        $this->handlerType       = $handlerDefinition->getType();
        $this->handlerParameters = $handlerDefinition->getParameters();

        return $this
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
