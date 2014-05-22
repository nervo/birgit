<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Project\Reference\Revision;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;

/**
 * Project reference revision
 */
class ProjectReferenceRevision extends Model\Project\Reference\Revision\ProjectReferenceRevision
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
