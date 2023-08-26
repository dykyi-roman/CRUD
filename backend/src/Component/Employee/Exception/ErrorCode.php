<?php

declare(strict_types=1);

namespace Component\Employee\Exception;

enum ErrorCode: int
{
    case DuplicateEmployee = 2001;
    case EmployeeNotFound = 2002;
    case SalaryShouldByGrater = 2003;
    case PastHiringDate = 2004;
}
