<?php

namespace Birgit\Bundle\TaskDoctrineBundle\Entity\Task\Queue;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Component\Task\Model;
use Birgit\Component\Parameters\Parameters;
use Birgit\Component\Handler\HandlerDefinition;

/**
 * Task queue
 */
class TaskQueue extends Model\Task\Queue\TaskQueue
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
     * Parent
     *
     * @var TaskQueue
     */
    protected $parent;

    /**
     * Children
     *
     * @var ArrayCollection
     */
    private $children;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        // Tasks
        $this->tasks = new ArrayCollection();

        // Children
        $this->children = new ArrayCollection();
    }

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
    public function setStatus(Model\Task\Queue\TaskQueueStatus $status)
    {
        $this->status = $status->get();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return new Model\Task\Queue\TaskQueueStatus(
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

    /**
     * Set parent
     *
     * @return TaskQueue
     */
    public function setParent(Model\Task\Queue\TaskQueue $parent)
    {
        return $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return TaskQueue
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(Model\Task\Queue\TaskQueue $child)
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeChild(Model\Task\Queue\TaskQueue $child)
    {
        $this->children->removeElement($child);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }
}
