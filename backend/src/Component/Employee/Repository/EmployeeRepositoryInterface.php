<?php

namespace Component\Employee\Repository;

use Component\Employee\Exception\EmployeeNotFoundException;
use Component\Employee\Model\EmployeeId;
use Component\Employee\Model\EmployeeInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

interface EmployeeRepositoryInterface
{
    /**
     * @throws UniqueConstraintViolationException
     */
    public function save(EmployeeInterface ...$collection): void;

    /**
     * @throws EmployeeNotFoundException
     */
    public function findById(EmployeeId $employeeId): EmployeeInterface;

    /**
     * @throws EmployeeNotFoundException
     */
    public function remove(EmployeeId $employeeId): void;

    /**
     * @return EmployeeInterface[]
     */
    public function listOf(array $criteria): array;
}
