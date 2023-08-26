<?php

namespace Tests\Functional\UI\Api\Action\Employee;

use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\Uid\Uuid;
use UI\Api\Action\Employee\UpdateEmployeeAction;

#[CoversClass(UpdateEmployeeAction::class)]
class UpdateEmployeeActionCest
{
    public function testUpdateEmployeeAction(\FunctionalTester $I): void
    {
        $data = [
            'firstName' => $firstName = 'fname-' . random_int(0, 1000),
            'lastName' => $lastName = 'lname-' . random_int(0, 1000),
            'salary' =>  $salary = random_int(1000, 10000),
            "currency" => "USD",
        ];

        $I->authorization();
        $I->createEmployeeInDB($id = Uuid::v4());
        $I->sendPatch(sprintf('/api/employee/%s', $id->toRfc4122()), $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeInDatabase('employee', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'salary' => $salary,
        ]);
    }
}