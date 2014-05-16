<?php

namespace Birgit\Component\Parameters;

class Parameters
{
    protected $parameters = array();

    public function __construct(array $parameters = array())
    {
        $this->parameters = array_merge(
            $this->parameters,
            $parameters
        );
                
        return $this;
    }
    
    public function all()
    {
        return $this->parameters;
    }

    public function set($name, $value)
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    public function get($name, $default = null)
    {
        if (array_key_exists($name, $this->parameters)) {
            return $this->parameters[$name];
        }

        return $default;
    }
}
