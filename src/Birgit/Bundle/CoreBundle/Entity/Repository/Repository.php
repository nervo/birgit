<?php

namespace Birgit\Bundle\CoreBundle\Entity\Repository;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;

/**
 * Repository
 */
class Repository extends Model\Repository\Repository
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
        // References
        $this->references = new ArrayCollection();

        // Projects
        $this->projects = new ArrayCollection();
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
