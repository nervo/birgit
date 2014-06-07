<?php

namespace Birgit\Base\Local\Project\Environment\Type;

use Birgit\Core\Project\Environment\Type\ProjectEnvironmentType;

/**
 * Local Project environment type
 */
class LocalProjectEnvironmentType extends ProjectEnvironmentType
{
    protected $rootDir;

    public function __construct($rootDir)
    {
        $this->rootDir = (string) $rootDir;
    }

    public function getAlias()
    {
        return 'local';
    }
}
