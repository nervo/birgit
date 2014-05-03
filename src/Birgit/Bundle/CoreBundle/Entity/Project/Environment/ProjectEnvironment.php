<?php

namespace Birgit\Bundle\CoreBundle\Entity\Project\Environment;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;

/**
 * Project environment
 */
class ProjectEnvironment extends Model\Project\Environment\ProjectEnvironment
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
        // Hosts
        $this->hosts = new ArrayCollection();
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
