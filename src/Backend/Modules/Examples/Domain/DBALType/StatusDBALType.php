<?php

namespace Backend\Modules\Examples\Domain\DBALType;

use Backend\Modules\Examples\Domain\ValueObject\Status;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class StatusDBALType extends StringType
{
    public function getName(): string
    {
        return 'status';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Status
    {
        if ($value === null) {
            return null;
        }

        return new Status($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        return (string) $value;
    }

}
