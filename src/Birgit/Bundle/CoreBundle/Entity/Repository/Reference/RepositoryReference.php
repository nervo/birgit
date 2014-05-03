<?php

namespace Birgit\Bundle\CoreBundle\Entity\Repository\Reference;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;

/**
 * Repository reference
 */
class RepositoryReference extends Model\Repository\Reference\RepositoryReference
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
