<?php

namespace Component\Employee\Module;

use Component\Employee\Dto\UpdateDto;
use Component\Employee\Exception\EmployeeDuplicateException;
use Component\Employee\Exception\EmployeeNotFoundException;
use Component\Employee\Exception\EmployeeUpdateException;
use Component\Employee\Model\EmployeeId;
use Component\Employee\Model\EmployeeInterface;
use Component\Employee\Repository\EmployeeRepositoryInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Psr\Log\LoggerInterface;

final readonly class EmployeeModule implements EmployeeModuleInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepository,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @throws EmployeeDuplicateException
     */
    public function create(EmployeeInterface $employee): void
    {
        try {
            $this->employeeRepository->save($employee);
        } catch (UniqueConstraintViolationException $exception) {
            $this->logger->error($exception->getMessage());

            throw new EmployeeDuplicateException($employee->emailAddress());
        }
    }

    /**
     * @throws EmployeeNotFoundException
     * @throws EmployeeUpdateException
     */
    public function update(EmployeeId $employeeId, UpdateDto $updateDto): EmployeeInterface
    {
        $employee = $this->findById($employeeId);
        try {
            $employee->changeFirstName($updateDto->firstName);
            $employee->changeLastName($updateDto->lastName);
            $employee->changeSalary($updateDto->salary);
            $this->employeeRepository->save();

            return $employee;
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());

            throw new EmployeeUpdateException($updateDto);
        }
    }

    /**
     * @throws EmployeeNotFoundException
     */
    public function findById(EmployeeId $employeeId): EmployeeInterface
    {
        return $this->employeeRepository->findById($employeeId);
    }

    /**
     * @throws EmployeeNotFoundException
     */
    public function delete(EmployeeId $employeeId): void
    {
        $this->employeeRepository->remove($employeeId);
    }

    public function findAll(array $criteria): array
    {
        return $this->employeeRepository->listOf($criteria);
    }
}
