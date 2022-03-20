<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220318070036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE salary_report ADD au_date DATE DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER INDEX idx_126c338f64e7214b RENAME TO IDX_126C338FAE80F5DF');
        $this->addSql('ALTER INDEX idx_126c338f9749932e RENAME TO IDX_126C338F8C03F15C');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE salary_report DROP au_date');
        $this->addSql('ALTER INDEX idx_126c338fae80f5df RENAME TO idx_126c338f64e7214b');
        $this->addSql('ALTER INDEX idx_126c338f8c03f15c RENAME TO idx_126c338f9749932e');
    }
}
