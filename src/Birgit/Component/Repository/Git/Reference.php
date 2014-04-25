<?php

namespace Birgit\Component\Repository\Git;

/**
 * Repository git reference
 */
class Reference
{
    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Revision
     *
     * @var string
     */
    protected $revision;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $revision
     */
    public function __construct($name, $revision)
    {
    	// Name
        $this->name = $name;

        // Revision
        $this->revision = $revision;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get revision
     *
     * @return string
     */
    public function getRevision()
    {
        return $this->revision;
    }
}
