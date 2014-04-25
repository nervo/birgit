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
     * Hash
     *
     * @var string
     */
    protected $hash;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $hash
     */
    public function __construct($name, $hash)
    {
    	// Name
        $this->name = $name;

        // Hash
        $this->hash = $hash;
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
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }
}
