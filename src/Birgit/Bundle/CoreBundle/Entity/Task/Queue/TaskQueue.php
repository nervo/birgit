<?php

namespace Birgit\Bundle\CoreBundle\Entity\Task\Queue;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;

class TaskQueue extends Model\Task\Queue\TaskQueue
{
    /**
     * Id
     *
     * @var int
     */
    private $id;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

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
}
