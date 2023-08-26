<?php

declare(strict_types=1);

namespace Infrastructure\Repository\DoctrineType;

use Component\Employee\Model\EmployeeId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Symfony\Component\Uid\Uuid;

final class EmployeeIdType extends GuidType
{
    public const NAME = 'employee_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return EmployeeId::fromString((string) $value);
    }

    /**
     * @param EmployeeId $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return Uuid::fromRfc4122((string) $value)->toBinary();
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
