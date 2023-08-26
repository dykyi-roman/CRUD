<?php

declare(strict_types=1);

namespace Component\Employee\Exception;

use Component\Employee\Model\EmailAddress;

final class EmployeeDuplicateException extends \RuntimeException
{
    public function __construct(EmailAddress $emailAddress)
    {
        parent::__construct(
            sprintf('Employee with email "%s" is exist.', (string) $emailAddress),
            ErrorCode::EmployeeNotFound->value,
        );
    }
}
