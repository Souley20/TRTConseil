<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514213655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_58DF0651E7927C74 ON administrateur');
        $this->addSql('ALTER TABLE administrateur ADD name VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_C8B28E44E7927C74 ON candidate');
        $this->addSql('DROP INDEX IDX_D930569D91BD8781 ON candidature');
        $this->addSql('DROP INDEX IDX_D930569D3481D195 ON candidature');
        $this->addSql('ALTER TABLE candidature DROP candidate_id, DROP joboffer_id');
        $this->addSql('DROP INDEX UNIQ_441282A1E7927C74 ON consultant');
        $this->addSql('ALTER TABLE consultant CHANGE email email VARCHAR(180) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_288A3A4E44F779A2 ON joboffer');
        $this->addSql('DROP INDEX IDX_288A3A4E156BE243 ON joboffer');
        $this->addSql('ALTER TABLE job_offer DROP consultant_id, DROP recruteur_id, CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_DE8633D8E7927C74 ON recruteur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joboffer ADD consultant_id INT DEFAULT NULL, ADD recruteur_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('CREATE INDEX IDX_288A3A4E44F779A2 ON joboffer (consultant_id)');
        $this->addSql('CREATE INDEX IDX_288A3A4E156BE243 ON joboffer (recruteur_id)');
        $this->addSql('ALTER TABLE administrateur DROP name');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_58DF0651E7927C74 ON administrateur (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C8B28E44E7927C74 ON candidate (email)');
        $this->addSql('ALTER TABLE candidature ADD candidate_id INT DEFAULT NULL, ADD joboffer_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_D930569D91BD8781 ON candidature (candidate_id)');
        $this->addSql('CREATE INDEX IDX_D930569D3481D195 ON candidature (joboffer_id)');
        $this->addSql('ALTER TABLE consultant CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_441282A1E7927C74 ON consultant (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DE8633D8E7927C74 ON recruteur (email)');
    }
}
