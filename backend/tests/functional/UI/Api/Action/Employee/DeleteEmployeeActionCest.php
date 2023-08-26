<?php

declare(strict_types=1);

namespace Tests\Functional\UI\Api\Action\Employee;

use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\Uid\Uuid;
use UI\Api\Action\Employee\DeleteEmployeeAction;

#[CoversClass(DeleteEmployeeAction::class)]
final class DeleteEmployeeActionCest
{
    public function testDeleteEmployee(\FunctionalTester $I): void
    {
        $I->authorization();
        $I->createEmployeeInDB($id = Uuid::v4());
        $I->sendDelete(sprintf('/api/employee/%s', $id->toRfc4122()));
        $I->canSeeResponseCodeIs(204);
        $I->cantSeeInDatabase(
            'employee',
            [
                'id' => $id->toRfc4122(),
            ],
        );
    }

    public function testDoNotDeleteEmployeeIsThrowExceptionWithFakeId(\FunctionalTester $I): void
    {
        $I->authorization();
        $I->sendDelete(sprintf('/api/employee/%s', Uuid::v4()));
        $I->canSeeResponseIsJson();
        $I->canSeeResponseCodeIs(500);
        $I->seeResponseJsonMatchesJsonPath('error');
    }
}
