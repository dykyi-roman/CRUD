<?php

declare(strict_types=1);

namespace Tests\Functional\UI\Api\Action\Employee;

use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\Uid\Uuid;
use UI\Api\Action\Employee\FindEmployeeAction;

#[CoversClass(FindEmployeeAction::class)]
final class FindEmployeeActionCest
{
    public function testCreateEmployee(\FunctionalTester $I): void
    {
        $I->createEmployeeInDB($id = Uuid::v4());
        $I->sendGet(sprintf('/api/employee/%s', $id->toRfc4122()));
        $I->canSeeResponseIsJson();
        $I->canSeeResponseCodeIs(200);
    }

    public function testCreateEmployIsThrowExceptionWithFakeId(\FunctionalTester $I): void
    {
        $I->sendGet(sprintf('/api/employee/%s', Uuid::v4()));
        $I->canSeeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('error');
        $I->canSeeResponseCodeIs(500);
    }
}
