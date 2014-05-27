<?php

namespace Birgit\Domain\Context;

interface ContextInterface
{
    public function getEventDispatcher();

    public function getLogger();
}
