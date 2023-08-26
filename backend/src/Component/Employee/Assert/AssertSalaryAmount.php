<?php

declare(strict_types=1);

namespace Component\Employee\Assert;

use Component\Employee\Exception\SalaryGratherAmountException;

final class AssertSalaryAmount
{
    private const MIN = 100;

    /**
     * @throws SalaryGratherAmountException
     */
    public static function validate(int $value): void
    {
        if (100 > $value) {
            throw new SalaryGratherAmountException(self::MIN);
        }
    }
}
