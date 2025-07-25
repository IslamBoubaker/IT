<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250715132132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14AA8A501D');
        $this->addSql('DROP INDEX IDX_CFBDFA14AA8A501D ON note');
        $this->addSql('ALTER TABLE note CHANGE stagiaiare_id stagiaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14BBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14BBA93DD6 ON note (stagiaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14BBA93DD6');
        $this->addSql('DROP INDEX IDX_CFBDFA14BBA93DD6 ON note');
        $this->addSql('ALTER TABLE note CHANGE stagiaire_id stagiaiare_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14AA8A501D FOREIGN KEY (stagiaiare_id) REFERENCES stagiaire (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CFBDFA14AA8A501D ON note (stagiaiare_id)');
    }
}
