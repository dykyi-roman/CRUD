<?php

declare(strict_types=1);

namespace Infrastructure\Repository\DoctrineType;

use Component\Employee\Model\EmailAddress;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class EmailAddressType extends StringType
{
    public const NAME = 'email_address';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): EmailAddress
    {
        return new EmailAddress((string) $value);
    }

    /**
     * @param EmailAddress $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return (string) $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
