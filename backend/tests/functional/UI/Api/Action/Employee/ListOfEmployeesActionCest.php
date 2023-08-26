<?php

namespace Tests\Functional\UI\Api\Action\Employee;

use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\Uid\Uuid;
use UI\Api\Action\Employee\ListOfEmployeesAction;

#[CoversClass(ListOfEmployeesAction::class)]
final class ListOfEmployeesActionCest
{
    public function testGetListOfEmployees(\FunctionalTester $I): void
    {
        $I->createEmployeeInDB(Uuid::v4());
        $I->createEmployeeInDB(Uuid::v4());
        $I->createEmployeeInDB(Uuid::v4());
        $I->sendGet(sprintf('/api/employee'));
        $I->canSeeResponseIsJson();
        $I->canSeeResponseCodeIs(200);

        if (count(\json_decode($I->grabResponse(), true, 512, JSON_THROW_ON_ERROR)) < 0) {
            throw new \RuntimeException(sprintf('Test %s is failed', __METHOD__));
        }
    }
}