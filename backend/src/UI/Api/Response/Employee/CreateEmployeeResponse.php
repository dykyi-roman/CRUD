<?php

declare(strict_types=1);

namespace UI\Api\Response\Employee;

use Application\Responder\ResponseInterface;
use Component\Employee\Model\EmployeeId;

final readonly class CreateEmployeeResponse implements ResponseInterface
{
    public function __construct(
        private EmployeeId $id,
    ) {
    }

    public function getBody(): array
    {
        return [
            'id' => (string) $this->id,
        ];
    }

    public function getStatusCode(): int
    {
        return 201;
    }
}
