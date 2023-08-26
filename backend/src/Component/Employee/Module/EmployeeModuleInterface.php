<?php

declare(strict_types=1);

namespace Component\Employee\Module;

use Component\Employee\Dto\UpdateDto;
use Component\Employee\Exception\EmployeeDuplicateException;
use Component\Employee\Exception\EmployeeNotFoundException;
use Component\Employee\Exception\EmployeeUpdateException;
use Component\Employee\Model\EmployeeId;
use Component\Employee\Model\EmployeeInterface;

interface EmployeeModuleInterface
{
    /**
     * @throws EmployeeDuplicateException
     */
    public function create(EmployeeInterface $employee): void;

    /**
     * @throws EmployeeUpdateException
     * @throws EmployeeNotFoundException
     */
    public function update(EmployeeId $employeeId, UpdateDto $updateDto): EmployeeInterface;

    /**
     * @throws EmployeeNotFoundException
     */
    public function findById(EmployeeId $employeeId): EmployeeInterface;

    /**
     * @throws EmployeeNotFoundException
     */
    public function delete(EmployeeId $employeeId): void;

    /**
     * @return EmployeeInterface[]
     */
    public function findAll(array $criteria): array;
}
