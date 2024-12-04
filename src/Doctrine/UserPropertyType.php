<?php

namespace App\Doctrine;

use App\ValueObject\UserProperty;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class UserPropertyType extends StringType
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return parent::getSQLDeclaration(array_merge($column, ['length' => UserProperty::MAX_LENGTH]), $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): UserProperty
    {
        return new UserProperty($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof UserProperty ? $value->getValue() : $value;
    }
}