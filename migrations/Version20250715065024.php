<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250715065024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formateur_validation (id INT AUTO_INCREMENT NOT NULL, formateur_id INT DEFAULT NULL, date_validation TINYINT(1) NOT NULL, pedagogiquement_valide TINYINT(1) NOT NULL, commentaire LONGTEXT DEFAULT NULL, premiere_fois TINYINT(1) NOT NULL, INDEX IDX_43BB79FB155D8F51 (formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formateur_validation ADD CONSTRAINT FK_43BB79FB155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formateur_validation DROP FOREIGN KEY FK_43BB79FB155D8F51');
        $this->addSql('DROP TABLE formateur_validation');
    }
}
