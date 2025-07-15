<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250711122118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alerte (id INT AUTO_INCREMENT NOT NULL, session_id INT DEFAULT NULL, niveau VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_3AE753A613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centre_formation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE checklist_logistique (id INT AUTO_INCREMENT NOT NULL, session_id INT DEFAULT NULL, reservation_salle TINYINT(1) NOT NULL, machines_installees TINYINT(1) NOT NULL, formateur_confirme TINYINT(1) NOT NULL, supports_imprimes TINYINT(1) NOT NULL, convocations_envoyees TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_329D2C5C613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commercial (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation_session (evaluation_id INT NOT NULL, session_id INT NOT NULL, INDEX IDX_F357CD5E456C5646 (evaluation_id), INDEX IDX_F357CD5E613FECDF (session_id), PRIMARY KEY(evaluation_id, session_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, cv LONGTEXT NOT NULL, est_valide TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, fiche_formation LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_sous_theme (formation_id INT NOT NULL, sous_theme_id INT NOT NULL, INDEX IDX_103934D45200282E (formation_id), INDEX IDX_103934D4514C40D2 (sous_theme_id), PRIMARY KEY(formation_id, sous_theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, session_id INT DEFAULT NULL, stagiaire_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_5E90F6D6613FECDF (session_id), INDEX IDX_5E90F6D6BBA93DD6 (stagiaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monitoring_session (id INT AUTO_INCREMENT NOT NULL, session_id INT DEFAULT NULL, etat_salle VARCHAR(255) NOT NULL, etat_supports VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E4393200613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT DEFAULT NULL, stagiaiare_id INT DEFAULT NULL, valeur SMALLINT NOT NULL, date DATETIME NOT NULL, INDEX IDX_CFBDFA14456C5646 (evaluation_id), INDEX IDX_CFBDFA14AA8A501D (stagiaiare_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relance_client (id INT AUTO_INCREMENT NOT NULL, stagiaire_id INT DEFAULT NULL, commercial_id INT DEFAULT NULL, date DATETIME NOT NULL, motif LONGTEXT NOT NULL, INDEX IDX_E4B414C6BBA93DD6 (stagiaire_id), INDEX IDX_E4B414C67854071C (commercial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, centre_formation_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, nombre_places INT NOT NULL, INDEX IDX_4E977E5C89FEAA37 (centre_formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, salle_id INT DEFAULT NULL, formateur_id INT DEFAULT NULL, date DATETIME NOT NULL, prix DOUBLE PRECISION NOT NULL, min_participants INT NOT NULL, INDEX IDX_D044D5D45200282E (formation_id), INDEX IDX_D044D5D4DC304035 (salle_id), INDEX IDX_D044D5D4155D8F51 (formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_theme (id INT AUTO_INCREMENT NOT NULL, theme_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_E891E7ED59027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stagiaire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, diplome VARCHAR(255) NOT NULL, prerequis_valide VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alerte ADD CONSTRAINT FK_3AE753A613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE checklist_logistique ADD CONSTRAINT FK_329D2C5C613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE evaluation_session ADD CONSTRAINT FK_F357CD5E456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_session ADD CONSTRAINT FK_F357CD5E613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_sous_theme ADD CONSTRAINT FK_103934D45200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_sous_theme ADD CONSTRAINT FK_103934D4514C40D2 FOREIGN KEY (sous_theme_id) REFERENCES sous_theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6BBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE monitoring_session ADD CONSTRAINT FK_E4393200613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14AA8A501D FOREIGN KEY (stagiaiare_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE relance_client ADD CONSTRAINT FK_E4B414C6BBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE relance_client ADD CONSTRAINT FK_E4B414C67854071C FOREIGN KEY (commercial_id) REFERENCES commercial (id)');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5C89FEAA37 FOREIGN KEY (centre_formation_id) REFERENCES centre_formation (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D45200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE sous_theme ADD CONSTRAINT FK_E891E7ED59027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alerte DROP FOREIGN KEY FK_3AE753A613FECDF');
        $this->addSql('ALTER TABLE checklist_logistique DROP FOREIGN KEY FK_329D2C5C613FECDF');
        $this->addSql('ALTER TABLE evaluation_session DROP FOREIGN KEY FK_F357CD5E456C5646');
        $this->addSql('ALTER TABLE evaluation_session DROP FOREIGN KEY FK_F357CD5E613FECDF');
        $this->addSql('ALTER TABLE formation_sous_theme DROP FOREIGN KEY FK_103934D45200282E');
        $this->addSql('ALTER TABLE formation_sous_theme DROP FOREIGN KEY FK_103934D4514C40D2');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6613FECDF');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6BBA93DD6');
        $this->addSql('ALTER TABLE monitoring_session DROP FOREIGN KEY FK_E4393200613FECDF');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14456C5646');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14AA8A501D');
        $this->addSql('ALTER TABLE relance_client DROP FOREIGN KEY FK_E4B414C6BBA93DD6');
        $this->addSql('ALTER TABLE relance_client DROP FOREIGN KEY FK_E4B414C67854071C');
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5C89FEAA37');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D45200282E');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4DC304035');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4155D8F51');
        $this->addSql('ALTER TABLE sous_theme DROP FOREIGN KEY FK_E891E7ED59027487');
        $this->addSql('DROP TABLE alerte');
        $this->addSql('DROP TABLE centre_formation');
        $this->addSql('DROP TABLE checklist_logistique');
        $this->addSql('DROP TABLE commercial');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE evaluation_session');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_sous_theme');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE monitoring_session');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE relance_client');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE sous_theme');
        $this->addSql('DROP TABLE stagiaire');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
