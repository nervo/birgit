<?php

namespace Birgit\Core\Project\Environment\Handler\Local;

use Birgit\Core\Project\Environment\Handler\ProjectEnvironmentHandler;

/**
 * Local Project environment handler
 */
class LocalProjectEnvironmentHandler extends ProjectEnvironmentHandler
{
    protected $rootDir;

    public function __construct($rootDir)
    {
        $this->rootDir = (string) $rootDir;
    }

    public function getType()
    {
        return 'local';
    }
}
