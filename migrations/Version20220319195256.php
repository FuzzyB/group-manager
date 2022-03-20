<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220319195256 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("insert into department (id, name, bonus_type, bonus_value)
             VALUES
                     (1, 'Accountancy', 'amount', '10000'),
                     (2, 'Logistic', 'percent', '0.1'),
                     (3, 'Finances', 'percent', '0.2'),
                     (4, 'Staff', 'amount', '13000'),
                     (5, 'Analytics', 'amount', '21000'),
                     (6, 'Opeartions', 'percent', '0.3')
        ");;
    }

    public function down(Schema $schema): void
    {
    }
}
