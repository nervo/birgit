<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Build;

use Birgit\Model;

/**
 * Build
 */
class Build extends Model\Build\Build
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
