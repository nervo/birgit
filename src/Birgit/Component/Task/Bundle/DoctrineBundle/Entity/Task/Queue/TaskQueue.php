<?php

namespace Birgit\Component\Task\Bundle\DoctrineBundle\Entity\Task\Queue;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Component\Task\Model;
use Birgit\Component\Type\TypeDefinition;

use Birgit\Component\Task\Bundle\DoctrineBundle\Entity\Task\Task;

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
     * Tail
     *
     * @var TaskQueue
     */
    protected $tail;

    /**
     * Predecessors
     *
     * @var ArrayCollection
     */
    private $predecessors;

    /**
     * Head
     *
     * @var TaskQueue
     */
    protected $head;

    /**
     * Successors
     *
     * @var ArrayCollection
     */
    private $successors;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        // Tasks
        $this->tasks = new ArrayCollection();

        // Predecessors
        $this->predecessors = new ArrayCollection();

        // Successors
        $this->successors = new ArrayCollection();
    }

    /**
     * Is new
     *
     * @return bool
     */
    public function isNew()
    {
        return !(bool) $this->id;
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
     * Add task
     *
     * @param Task $task
     *
     * @return TaskQueue
     */
    public function addTask(Task $task)
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setQueue($this);
        }

        return $this;
    }

    /**
     * Remove task
     *
     * @param Task $task
     *
     * @return TaskQueue
     */
    public function removeTask(Task $task)
    {
        $this->tasks->removeElement($task);

        return $this;
    }

    /**
     * Get tasks
     *
     * @return Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Type Definition : Set alias
     *
     * @param string $alias
     *
     * @return TaskQueue
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
     * @return TaskQueue
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
     * @return TaskQueue
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

    /**
     * Set tail
     *
     * @return TaskQueue
     */
    public function setTail(TaskQueue $tail)
    {
        return $this->tail = $tail;
    }

    /**
     * Get tail
     *
     * @return TaskQueue|null
     */
    public function getTail()
    {
        return $this->tail;
    }

    /**
     * Add predecessor
     *
     * @param TaskQueue $predecessor
     *
     * @return TaskQueue
     */
    public function addPredecessor(TaskQueue $predecessor)
    {
        if (!$this->predecessors->contains($predecessor)) {
            $this->predecessors->add($predecessor);
            $predecessor->setTail($this);
        }

        return $this;
    }

    /**
     * Remove predecessor
     *
     * @param TaskQueue $predecessor
     *
     * @return TaskQueue
     */
    public function removePredecessor(TaskQueue $predecessor)
    {
        $this->predecessors->removeElement($predecessor);

        return $this;
    }

    /**
     * Get predecessors
     *
     * @return Collection
     */
    public function getPredecessors()
    {
        return $this->predecessors;
    }

    /**
     * Set head
     *
     * @return TaskQueue
     */
    public function setHead(TaskQueue $head)
    {
        return $this->head = $head;
    }

    /**
     * Get head
     *
     * @return TaskQueue|null
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Add successor
     *
     * @param TaskQueue $successor
     *
     * @return TaskQueue
     */
    public function addSuccessor(TaskQueue $successor)
    {
        if (!$this->successors->contains($successor)) {
            $this->successors->add($successor);
            $successor->setHead($this);
        }

        return $this;
    }

    /**
     * Remove successor
     *
     * @param TaskQueue $successor
     *
     * @return TaskQueue
     */
    public function removeSuccessor(TaskQueue $successor)
    {
        $this->successors->removeElement($successor);

        return $this;
    }

    /**
     * Get successors
     *
     * @return Collection
     */
    public function getSuccessors()
    {
        return $this->successors;
    }
}
