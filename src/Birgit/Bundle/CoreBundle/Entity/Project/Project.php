<?php

namespace Birgit\Bundle\CoreBundle\Entity\Project;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;

/**
 * Project
 */
class Project extends Model\Project\Project
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
        // Environments
        $this->environments = new ArrayCollection();
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
