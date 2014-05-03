<?php

namespace Birgit\Model;


interface TypeInterface
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
