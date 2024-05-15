<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514210459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE joboffer');
        $this->addSql('DROP TABLE consultant');        
        $this->addSql('DROP TABLE recruteur');
        $this->addSql('DROP INDEX UNIQ_58DF0651E7927C74 ON administrateur');
        $this->addSql('ALTER TABLE administrateur ADD name VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_C8B28E44E7927C74 ON candidate');
        $this->addSql('DROP INDEX IDX_D930569D91BD8781 ON candidature');
        $this->addSql('DROP INDEX IDX_D930569D3481D195 ON candidature');
        $this->addSql('ALTER TABLE candidature DROP candidate_id, DROP job_offer_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE joboffer (id INT AUTO_INCREMENT NOT NULL, consultant_id INT DEFAULT NULL, recruteur_id INT DEFAULT NULL, job_title VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, workplace VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, is_valid TINYINT(1) NOT NULL, salary INT NOT NULL, schedule INT NOT NULL, INDEX IDX_288A3A4E44F779A2 (consultant_id), INDEX IDX_288A3A4E156BE243 (recruteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE consultant (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, roles JSON NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, firstname VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, lastname VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, UNIQUE INDEX UNIQ_441282A1E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');       
        $this->addSql('CREATE TABLE recruteur (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, lastname VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, roles JSON NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, company_name VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, company_address VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, is_valid TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_DE8633D8E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('ALTER TABLE administrateur DROP name');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_58DF0651E7927C74 ON administrateur (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C8B28E44E7927C74 ON candidate (email)');
        $this->addSql('ALTER TABLE candidature ADD candidate_id INT DEFAULT NULL, ADD joboffer_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_D930569D91BD8781 ON candidature (candidate_id)');
        $this->addSql('CREATE INDEX IDX_D930569D3481D195 ON candidature (joboffer_id)');
    }
}
