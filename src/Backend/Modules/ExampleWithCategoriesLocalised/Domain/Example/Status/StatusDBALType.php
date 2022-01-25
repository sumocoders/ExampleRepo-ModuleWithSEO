<?php

namespace Backend\Modules\Example\Domain\Example\Status;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class StatusDBALType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValue((string) $value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Status($value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getName(): string
    {
        return 'status';
    }
}
