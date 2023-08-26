<?php

declare(strict_types=1);

namespace UI\Api\Response\Employee;

use Application\Responder\ResponseInterface;

final readonly class DeleteEmployeeResponse implements ResponseInterface
{
    public function getBody(): array
    {
        return [];
    }

    public function getStatusCode(): int
    {
        return 204;
    }
}
