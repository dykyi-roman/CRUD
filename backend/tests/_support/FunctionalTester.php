<?php

use Symfony\Component\Uid\Uuid;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    public function authorization(): void
    {
        $this->haveHttpHeader('Accept', 'application/json');
        $this->haveHttpHeader('Content-Type', 'application/json');
    }

    public function createEmployeeInDB(Uuid $id, array $data = []): void
    {
        $this->haveInDatabase('employee', [
            'id' => $id->toBinary(),
            'first_name' => $data['first_name'] ?? 'test-name-' . random_int(0, 1000),
            'last_name' => $data['last_name'] ?? 'test-address-' . random_int(0, 1000),
            'email_address' => $data['email_address'] ?? sprintf('test%d@gmail.com', random_int(1,1000)),
            'salary' => $data['salary'] ?? random_int(1000, 10000),
            'currency' => $data['currency'] ?? 'USD',
            'hiring_at' => $data['hiring_at'] ?? '2030-01-01 00:00:00',
            'created_at' => (new DateTimeImmutable())->format('Y-m-d'),
            'updated_at' => (new DateTimeImmutable())->format('Y-m-d'),
        ]);
    }
}
