<?php

declare(strict_types=1);

namespace Component\Employee\Exception;

use Infrastructure\Helper\DateTime\Formatter;

final class HiringDateInThePastException extends \RuntimeException
{
    public function __construct(\DateTimeImmutable $value)
    {
        parent::__construct(
            sprintf('Past hiring date "%s".', Formatter::transform($value)),
            ErrorCode::PastHiringDate->value,
        );
    }
}
