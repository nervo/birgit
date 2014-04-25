<?php

namespace Birgit\Component\Command;

/**
 * Command
 */
class Command
{
    /**
     * Command
     *
     * @var string
     */
    protected $command;

    /**
     * Arguments
     *
     * @var array
     */
    protected $arguments = array();

    /**
     * Set command
     *
     * @param string $command
     *
     * @return Command
     */
    public function setCommand($command)
    {
        $this->command = (string) $command;

        return $this;
    }

    /**
     * Add argument
     *
     * @param string $argument
     *
     * @return Command
     */
    public function addArgument($argument)
    {
        $this->arguments[] = $argument;

        return $this;
    }

    /**
     * Get arguments
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }
}
