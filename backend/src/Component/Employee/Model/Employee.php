<?php

declare(strict_types=1);

namespace Component\Employee\Model;

use Component\Employee\Assert\AssertHiringDateInTheFuture;
use Component\Employee\Assert\AssertSalaryAmount;
use Component\Employee\Enum\Currency;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Infrastructure\Repository\DoctrineType\EmailAddressType;
use Infrastructure\Repository\DoctrineType\EmployeeIdType;

#[ORM\Entity(repositoryClass: Employee::class)] // @phpstan-ignore-line
class Employee implements EmployeeInterface
{
    #[ORM\Id]
    #[ORM\Column(type: EmployeeIdType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private EmployeeId $id;

    #[ORM\Column(length: 255)]
    private string $firstName;

    #[ORM\Column(length: 255)]
    private string $lastName;

    #[ORM\Column(type: EmailAddressType::NAME)]
    private EmailAddress $emailAddress;

    #[ORM\Column]
    private int $salary;

    #[ORM\Column(length: 5)]
    private string $currency;

    #[ORM\Column(name: 'hiring_at', type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $hiringAt;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        EmployeeId $id,
        string $firstName,
        string $lastName,
        EmailAddress $emailAddress,
        Money $salary,
        \DateTimeImmutable $hiringAt,
    ) {
        AssertSalaryAmount::validate($salary->amount);
        AssertHiringDateInTheFuture::validate($hiringAt);

        $this->id = $id;
        $this->emailAddress = $emailAddress;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->salary = $salary->amount;
        $this->currency = $salary->currency->value;
        $this->hiringAt = $hiringAt;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function id(): EmployeeId
    {
        return $this->id;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastNameName(): string
    {
        return $this->lastName;
    }

    public function salary(): Money
    {
        return new Money($this->salary, Currency::from($this->currency));
    }

    public function emailAddress(): EmailAddress
    {
        return $this->emailAddress;
    }

    public function hiringAt(): \DateTimeImmutable
    {
        return $this->hiringAt;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function changeFirstName(string $value): void
    {
        $this->firstName = $value;
    }

    public function changeLastName(string $value): void
    {
        $this->lastName = $value;
    }

    public function changeSalary(Money $money): void
    {
        $this->salary = $money->amount;
        $this->currency = $money->currency->value;
    }
}
