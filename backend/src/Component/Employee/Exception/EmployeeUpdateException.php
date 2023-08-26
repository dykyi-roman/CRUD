<?php

declare(strict_types=1);

namespace Component\Employee\Exception;

use Component\Employee\Dto\UpdateDto;

final class EmployeeUpdateException extends \RuntimeException
{
    public function __construct(UpdateDto $updateDto)
    {
        parent::__construct(
            sprintf('Employee update error. Data: %s', implode(',', $updateDto->jsonSerialize())),
            ErrorCode::EmployeeNotFound->value,
        );
    }
}
