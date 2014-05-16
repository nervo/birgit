<?php

namespace Birgit\Component\Parameters\Doctrine;

use Doctrine\DBAL\Types\JsonArrayType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

use Birgit\Component\Parameters\Parameters;

class ParametersType extends JsonArrayType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'parameters';
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return json_encode($value->all());
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Parameters(json_decode($value, true));
    }
}
