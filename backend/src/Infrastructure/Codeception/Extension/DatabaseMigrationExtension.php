<?php

declare(strict_types=1);

namespace Infrastructure\Codeception\Extension;

use Codeception\Events;
use Codeception\Extension;

final class DatabaseMigrationExtension extends Extension
{
    public static array $events = [
        Events::SUITE_BEFORE => 'beforeSuite',
    ];

    public function beforeSuite(): void
    {
        echo exec('bin/console --env=test doctrine:migrations:migrate -n').PHP_EOL;
    }
}
