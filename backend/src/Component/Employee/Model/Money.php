<?php

declare(strict_types=1);

namespace Component\Employee\Model;

use Component\Employee\Enum\Currency;

final readonly class Money implements \Stringable
{
    public function __construct(
        public int $amount,
        public Currency $currency,
    ) {
    }

    public function __toString(): string
    {
        return sprintf('%d (%s)', $this->amount, $this->currency->name);
    }
}
