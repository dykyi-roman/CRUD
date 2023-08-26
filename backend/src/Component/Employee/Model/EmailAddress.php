<?php

declare(strict_types=1);

namespace Component\Employee\Model;

use Component\Employee\Assert\AssertEmail;

final class EmailAddress implements \Stringable
{
    public function __construct(private string $value)
    {
        AssertEmail::validate($this->value);

        $this->value = trim($this->value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
