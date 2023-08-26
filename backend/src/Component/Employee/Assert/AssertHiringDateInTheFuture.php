<?php

declare(strict_types=1);

namespace Component\Employee\Assert;

use Component\Employee\Exception\HiringDateInThePastException;

final class AssertHiringDateInTheFuture
{
    /**
     * @throws HiringDateInThePastException
     */
    public static function validate(\DateTimeImmutable $hiringAt): void
    {
        if ($hiringAt < new \DateTimeImmutable()) {
            throw new HiringDateInThePastException($hiringAt);
        }
    }
}
