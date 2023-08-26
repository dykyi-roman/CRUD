<?php

namespace Component\Employee\Model;

interface EmployeeInterface
{
    public function id(): EmployeeId;

    public function salary(): Money;

    public function firstName(): string;

    public function lastNameName(): string;

    public function emailAddress(): EmailAddress;

    public function hiringAt(): \DateTimeImmutable;

    public function createdAt(): \DateTimeImmutable;

    public function updatedAt(): \DateTimeImmutable;

    public function changeFirstName(string $value): void;

    public function changeLastName(string $value): void;

    public function changeSalary(Money $money): void;
}
