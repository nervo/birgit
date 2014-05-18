<?php

namespace Birgit\Component\Type;

interface TypeModelInterface
{
    /**
     * Get type
     *
     * @return string
     */
    public function getType();

    /**
     * Get parameters
     *
     * @return array
     */
    public function getParameters();
}
