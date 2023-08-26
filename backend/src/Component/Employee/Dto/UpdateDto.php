<?php

declare(strict_types=1);

namespace Component\Employee\Dto;

use Component\Employee\Model\Money;

final readonly class UpdateDto implements \JsonSerializable
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public Money $salary,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'salary' => (string) $this->salary,
        ];
    }
}
