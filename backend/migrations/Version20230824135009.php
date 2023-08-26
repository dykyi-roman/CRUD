<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230824135009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table `employee`';
    }

    public function up(Schema $schema): void
    {
        $this->skipIf($schema->hasTable('employee'), 'table employee already exists');
        $this->addSql('
            create table employee
            (
                id            binary(16)       not null,
                first_name    varchar(255)     not null,
                last_name     varchar(255)     not null,
                email_address varchar(80)      not null,
                salary        integer          not null,
                currency      varchar(5)       not null,
                hiring_at     datetime         not null,
                created_at    datetime         not null,
                updated_at    datetime         not null
            );
        ');

        $this->addSql('alter table employee add constraint employee_table_email_address unique (email_address);');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop table employee;');
    }
}
