<?php

namespace Birgit\Bundle\CoreBundle\Entity\Host\Provider;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;

/**
 * Host provider
 */
class HostProvider extends Model\Host\Provider\HostProvider
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
