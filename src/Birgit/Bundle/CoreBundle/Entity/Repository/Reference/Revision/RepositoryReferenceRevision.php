<?php

namespace Birgit\Bundle\CoreBundle\Entity\Repository\Reference\Revision;

use Doctrine\Common\Collections\Collection;

use Birgit\Model;

/**
 * Repository reference revision
 */
class RepositoryReferenceRevision extends Model\Repository\Reference\Revision\RepositoryReferenceRevision
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
