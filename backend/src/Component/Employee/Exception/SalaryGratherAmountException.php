<?php

declare(strict_types=1);

namespace Component\Employee\Exception;

final class SalaryGratherAmountException extends \RuntimeException
{
    public function __construct(int $value)
    {
        parent::__construct(
            sprintf('Salary it should be grather "%d".', $value),
            ErrorCode::SalaryShouldByGrater->value,
        );
    }
}
