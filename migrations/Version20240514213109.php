<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514213109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_58DF0651E7927C74 ON administrator');
        $this->addSql('ALTER TABLE administrator ADD name VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_C8B28E44E7927C74 ON candidate');
        $this->addSql('DROP INDEX IDX_D930569D91BD8781 ON candidacy');
        $this->addSql('DROP INDEX IDX_D930569D3481D195 ON candidacy');
        $this->addSql('ALTER TABLE candidacy DROP candidate_id, DROP joboffer_id');
        $this->addSql('DROP INDEX UNIQ_441282A1E7927C74 ON consultant');
        $this->addSql('ALTER TABLE consultant CHANGE email email VARCHAR(180) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_288A3A4E44F779A2 ON job_offer');
        $this->addSql('DROP INDEX IDX_288A3A4E156BE243 ON job_offer');
        $this->addSql('ALTER TABLE joboffer DROP consultant_id, DROP recruiter_id, CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_DE8633D8E7927C74 ON recruiter');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joboffer ADD consultant_id INT DEFAULT NULL, ADD recruiter_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('CREATE INDEX IDX_288A3A4E44F779A2 ON joboffer (consultant_id)');
        $this->addSql('CREATE INDEX IDX_288A3A4E156BE243 ON joboffer (recruiter_id)');
        $this->addSql('ALTER TABLE administrateur DROP name');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_58DF0651E7927C74 ON administrator (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C8B28E44E7927C74 ON candidate (email)');
        $this->addSql('ALTER TABLE candidacy ADD candidate_id INT DEFAULT NULL, ADD joboffer_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_D930569D91BD8781 ON candidacy (candidate_id)');
        $this->addSql('CREATE INDEX IDX_D930569D3481D195 ON candidacy (joboffer_id)');
        $this->addSql('ALTER TABLE consultant CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_441282A1E7927C74 ON consultant (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DE8633D8E7927C74 ON recruiter (email)');
    }
}
