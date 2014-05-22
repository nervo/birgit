<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Task;

use Birgit\Model;

class Task extends Model\Task\Task
{
    /**
     * Id
     *
     * @var int
     */
    private $id;

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
