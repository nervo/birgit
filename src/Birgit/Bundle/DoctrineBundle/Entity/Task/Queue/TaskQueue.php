<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Task\Queue;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;
use Birgit\Component\Parameters\Parameters;
use Birgit\Domain\Handler\HandlerDefinition;

/**
 * Task queue
 */
class TaskQueue extends Model\Task\Queue\TaskQueue
{
    /**
     * Id
     *
     * @var int
     */
    private $id;

    /**
     * Tasks
     *
     * @var ArrayCollection
     */
    private $tasks;

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
        // Tasks
        $this->tasks = new ArrayCollection();
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
    public function addTask(Model\Task\Task $task)
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setQueue($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeTask(Model\Task\Task $task)
    {
        $this->tasks->removeElement($task);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Handler Definition : Set type
     *
     * @param string $type
     *
     * @return TaskQueue
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
     * @return TaskQueue
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
