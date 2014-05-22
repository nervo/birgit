<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Project\Reference;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;

/**
 * Project reference
 */
class ProjectReference extends Model\Project\Reference\ProjectReference
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
        // Revisions
        $this->revisions = new ArrayCollection();

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
