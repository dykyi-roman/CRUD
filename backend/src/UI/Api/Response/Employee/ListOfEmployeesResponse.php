<?php

declare(strict_types=1);

namespace UI\Api\Response\Employee;

use Application\Responder\ResponseInterface;
use Component\Employee\Model\EmployeeInterface;

final readonly class ListOfEmployeesResponse implements ResponseInterface
{
    public function __construct(
        private array $collection,
    ) {
    }

    public function getBody(): array
    {
        return array_map(
            static fn (EmployeeInterface $model): array => FindEmployeeResponse::fromModel($model)->getBody(),
            $this->collection,
        );
    }

    public function getStatusCode(): int
    {
        return 200;
    }
}
