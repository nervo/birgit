<?php

namespace Birgit\Component\Context;

interface ContextInterface
{
    public function getEventDispatcher();

    public function getLogger();
}
