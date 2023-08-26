<?php

declare(strict_types=1);

namespace Component\Employee\Enum;

enum Currency: string
{
    case UAH = 'UAH';
    case USD = 'USD';
    case EURO = 'EURO';
}
