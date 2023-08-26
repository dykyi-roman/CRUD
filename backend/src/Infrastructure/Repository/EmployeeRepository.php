<?php

declare(strict_types=1);

namespace Infrastructure\Repository;

use Component\Employee\Exception\EmployeeNotFoundException;
use Component\Employee\Model\Employee;
use Component\Employee\Model\EmployeeId;
use Component\Employee\Model\EmployeeInterface;
use Component\Employee\Repository\EmployeeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;

final class EmployeeRepository extends ServiceEntityRepository implements EmployeeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * @throws UniqueConstraintViolationException
     */
    public function save(EmployeeInterface ...$collection): void
    {
        foreach ($collection as $item) {
            $this->getEntityManager()->persist($item);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @throws EmployeeNotFoundException
     */
    public function findById(EmployeeId $employeeId): EmployeeInterface
    {
        // @phpstan-ignore-next-line
        return $this->findOneBy(['id' => (string) $employeeId]) ?? throw new EmployeeNotFoundException($employeeId);
    }

    /**
     * @return array<int, EmployeeInterface>
     */
    public function listOf(array $criteria): array
    {
        // @phpstan-ignore-next-line
        return $this->findAll() ?? [];
    }

    /**
     * @throws EmployeeNotFoundException
     */
    public function remove(EmployeeId $employeeId): void
    {
        $this->getEntityManager()->remove($this->findById($employeeId));
        $this->getEntityManager()->flush();
    }
}
