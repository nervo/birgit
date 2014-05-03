<?php

namespace Birgit\Bundle\CoreBundle\Entity\Host;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;

/**
 * Host
 */
class Host extends Model\Host\Host
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
        // Builds
        $this->builds = new ArrayCollection();
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
