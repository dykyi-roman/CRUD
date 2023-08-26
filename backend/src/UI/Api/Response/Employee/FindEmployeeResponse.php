<?php

declare(strict_types=1);

namespace UI\Api\Response\Employee;

use Application\Responder\ResponseInterface;
use Component\Employee\Model\EmployeeInterface;
use Infrastructure\Helper\DateTime\Formatter;

final readonly class FindEmployeeResponse implements ResponseInterface
{
    public function __construct(private array $data)
    {
    }

    public static function fromModel(EmployeeInterface $employee): self
    {
        return new self([
            'id' => (string) $employee->id(),
            'emailAddress' => (string) $employee->emailAddress(),
            'firstName' => $employee->firstName(),
            'lastName' => $employee->lastNameName(),
            'salary' => (string) $employee->salary(),
            'hiringAt' => Formatter::transform($employee->hiringAt()),
            'createdAt' => Formatter::transform($employee->createdAt()),
            'updatedAt' => Formatter::transform($employee->updatedAt()),
        ]);
    }

    public function getBody(): array
    {
        return $this->data;
    }

    public function getStatusCode(): int
    {
        return 200;
    }
}
