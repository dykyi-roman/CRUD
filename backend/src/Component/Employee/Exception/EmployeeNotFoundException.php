<?php

declare(strict_types=1);

namespace Component\Employee\Exception;

use Component\Employee\Model\EmployeeId;

final class EmployeeNotFoundException extends \RuntimeException
{
    public function __construct(EmployeeId $employeeId)
    {
        parent::__construct(
            sprintf('Employee with id "%s" not found.', (string) $employeeId),
            ErrorCode::DuplicateEmployee->value,
        );
    }
}
