<?php

declare(strict_types=1);

namespace Tests\Functional\UI\Api\Action\Employee;

use PHPUnit\Framework\Attributes\CoversClass;
use UI\Api\Action\Employee\CreateEmployeeAction;

#[CoversClass(CreateEmployeeAction::class)]
final class CreateEmployeeActionCest
{
    public function testCreateEmployee(\FunctionalTester $I): void
    {
        $data = [
            'firstName' => $firstName = 'fname-' . random_int(0, 1000),
            'lastName' => $lastName = 'lname-' . random_int(0, 1000),
            'emailAddress' => $emailAddress = sprintf('test%d@gmail.com', random_int(0, 1000)),
            'salary' =>  random_int(1000, 10000),
            'currency' => 'USD',
            'hiringAt' => '2030-01-01 00:00:00'
        ];

        $I->authorization();
        $I->sendPost('/api/employee', $data);
        $I->canSeeResponseIsJson();
        $I->canSeeResponseCodeIs(201);
        $I->seeInDatabase('employee', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email_address' => $emailAddress,
        ]);
    }

    public function testDoNotCreateCreateEmployeeIsThrowExceptionWhenDataIsEmpty(\FunctionalTester $I): void
    {
        $data = [];

        $I->authorization();
        $I->sendPost('/api/employee', $data);
        $I->canSeeResponseIsJson();
        $I->canSeeResponseCodeIs(500);
        $I->seeResponseJsonMatchesJsonPath('error');
    }

    public function testDoNotCreateCreateEmployeeIsThrowExceptionWhenSalaryLess100IsEmpty(\FunctionalTester $I): void
    {
        $data = [
            'firstName' => 'fname-' . random_int(0, 1000),
            'lastName' => 'lname-' . random_int(0, 1000),
            'emailAddress' => sprintf('test%d@gmail.com', random_int(0, 1000)),
            'salary' =>  random_int(0, 99),
            'currency' => 'USD',
            'hiringAt' => '2030-01-01 00:00:00'
        ];

        $I->authorization();
        $I->sendPost('/api/employee', $data);
        $I->canSeeResponseIsJson();
        $I->canSeeResponseCodeIs(500);
        $I->seeResponseJsonMatchesJsonPath('error');
    }

    public function testDoNotCreateCreateIsThrowExceptionEmployeeWhenHiringDateInPastIsEmpty(\FunctionalTester $I): void
    {
        $data = [
            'firstName' => 'fname-' . random_int(0, 1000),
            'lastName' => 'lname-' . random_int(0, 1000),
            'emailAddress' => sprintf('test%d@gmail.com', random_int(0, 1000)),
            'salary' =>  random_int(0, 99),
            'currency' => 'USD',
            'hiringAt' => '1997-01-01 00:00:00'
        ];

        $I->authorization();
        $I->sendPost('/api/employee', $data);
        $I->canSeeResponseIsJson();
        $I->canSeeResponseCodeIs(500);
        $I->seeResponseJsonMatchesJsonPath('error');
    }
}
