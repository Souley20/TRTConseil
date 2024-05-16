<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514224821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidate (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(30) DEFAULT NULL, lastname VARCHAR(30) DEFAULT NULL, cv VARCHAR(255) DEFAULT NULL, is_valid TINYINT(1) NOT NULL, job VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultant (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(30) DEFAULT NULL, lastname VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_offer (id INT AUTO_INCREMENT NOT NULL, jobTitle VARCHAR(30) NOT NULL, workplace VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, is_valid TINYINT(1) NOT NULL, salary INT NOT NULL, schedule INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE joboffer');
        $this->addSql('ALTER TABLE candidacy CHANGE candidate_id candidate_id INT NOT NULL, CHANGE joboffer_id joboffer_id INT NOT NULL');
        $this->addSql('ALTER TABLE candidacy RENAME INDEX idx_d930569d91bd8781 TO IDX_E33BD3B891BD8781');
        $this->addSql('ALTER TABLE candidacy RENAME INDEX idx_d930569d3481d195 TO IDX_E33BD3B83481D195');
        $this->addSql('DROP INDEX UNIQ_DE8633D8E7927C74 ON recruteur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_E33BD3B891BD8781');
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_E33BD3B83481D195');
        $this->addSql('CREATE TABLE joboffer (id INT AUTO_INCREMENT NOT NULL, consultant_id INT DEFAULT NULL, recruiter_id INT DEFAULT NULL, jobTitle VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, workplace VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, is_valid TINYINT(1) NOT NULL, salary INT NOT NULL, schedule INT NOT NULL, INDEX IDX_288A3A4E44F779A2 (consultant_id), INDEX IDX_288A3A4E156BE243 (recruiter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('DROP TABLE candidate');
        $this->addSql('DROP TABLE consultant');
        $this->addSql('DROP TABLE joboffer');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DE8633D8E7927C74 ON recruteur (email)');
        $this->addSql('ALTER TABLE candidacy CHANGE candidate_id candidate_id INT DEFAULT NULL, CHANGE joboffer_id joboffer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidacy RENAME INDEX idx_e33bd3b891bd8781 TO IDX_D930569D91BD8781');
        $this->addSql('ALTER TABLE candidacy RENAME INDEX idx_e33bd3b83481d195 TO IDX_D930569D3481D195');
    }
}
