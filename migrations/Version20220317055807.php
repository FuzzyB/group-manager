<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317055807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE salary_report_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE salary_report (id INT NOT NULL, department_id INT NOT NULL, employee_id INT NOT NULL, employee_name VARCHAR(255) NOT NULL, employee_surname VARCHAR(255) NOT NULL, department_name VARCHAR(255) NOT NULL, bonus_salary DOUBLE PRECISION DEFAULT NULL, salary_bonus_type VARCHAR(255) DEFAULT NULL, salary INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_126C338F64E7214B ON salary_report (department_id)');
        $this->addSql('CREATE INDEX IDX_126C338F9749932E ON salary_report (employee_id)');
        $this->addSql('ALTER TABLE salary_report ADD CONSTRAINT FK_126C338F64E7214B FOREIGN KEY (department_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE salary_report ADD CONSTRAINT FK_126C338F9749932E FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
//        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE salary_report_id_seq CASCADE');
        $this->addSql('DROP TABLE salary_report');
    }
}
