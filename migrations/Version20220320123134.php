<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220320123134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE employee DROP COLUMN fk_department_id");
        $this->addSql("INSERT INTO employee (id, base_salary, name, surname, end_of_work_date, start_of_work_date, department_id)
            VALUES (1, 110000, 'Jan', 'Kowalski', '2022-01-09', '2022-01-01', 1),
                   (2, 110000, 'Adam', 'Zuch', '2021-01-09', '2022-01-01', 2),
                   (3, 110000, 'Karol', 'Buk', '2022-01-09', '2022-01-01', 3),
                   (4, 110000, 'Paweł', 'Bogdan', NULL, '2020-01-01', 4),
                   (5, 110000, 'Monika', 'Jaroszek', NULL, '2022-02-11', 5),
                   (6, 110000, 'Agata', 'Magiel', '2022-02-02', '2022-02-6', 6)"
        );
    }

    public function down(Schema $schema): void
    {

    }
}
