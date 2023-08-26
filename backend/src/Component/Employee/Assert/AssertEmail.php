<?php

declare(strict_types=1);

namespace Component\Employee\Assert;

final class AssertEmail
{
    /**
     * @throws \RuntimeException
     */
    public static function validate(string $value): void
    {
        if ('' === $value) {
            throw new \RuntimeException('Email is empty');
        }

        if (false === \filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException(sprintf('Invalid e-mail address %s', $value));
        }
    }
}
