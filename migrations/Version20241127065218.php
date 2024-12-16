<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241127065218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidat (id VARCHAR(255) NOT NULL, nom VARCHAR(70) NOT NULL, prenom VARCHAR(70) NOT NULL, email VARCHAR(180) NOT NULL, telephone VARCHAR(255) NOT NULL, nom_fichier_cv VARCHAR(255) NOT NULL, date_creation DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE candidat_offre_emploi (candidat_id VARCHAR(255) NOT NULL, offre_emploi_id INT NOT NULL, PRIMARY KEY(candidat_id, offre_emploi_id))');
        $this->addSql('CREATE INDEX IDX_B1E2339A8D0EB82 ON candidat_offre_emploi (candidat_id)');
        $this->addSql('CREATE INDEX IDX_B1E2339AB08996ED ON candidat_offre_emploi (offre_emploi_id)');
        $this->addSql('CREATE TABLE contrat (id VARCHAR(255) NOT NULL, type_id VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, duree SMALLINT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_60349993C54C8C93 ON contrat (type_id)');
        $this->addSql('CREATE TABLE demande_conge (id SERIAL NOT NULL, id_utilisateur VARCHAR(255) NOT NULL, id_type_conge VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, description VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D806106150EAE44 ON demande_conge (id_utilisateur)');
        $this->addSql('CREATE INDEX IDX_D8061061855E9468 ON demande_conge (id_type_conge)');
        $this->addSql('CREATE TABLE departement (id VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE detail_evaluation (evaluation_id VARCHAR(255) NOT NULL, comportement NUMERIC(3, 2) DEFAULT NULL, attitude NUMERIC(3, 2) DEFAULT NULL, competence NUMERIC(3, 2) DEFAULT NULL, connaissance NUMERIC(3, 2) DEFAULT NULL, administrative NUMERIC(3, 2) DEFAULT NULL, PRIMARY KEY(evaluation_id))');
        $this->addSql('CREATE TABLE entretien (id SERIAL NOT NULL, candidat_id VARCHAR(255) NOT NULL, date_heure_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_heure_prevue TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, statut VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, commentaires TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2B58D6DA8D0EB82 ON entretien (candidat_id)');
        $this->addSql('CREATE TABLE entretien_recruteur (id_entretien INT NOT NULL, id_recruteur VARCHAR(255) NOT NULL, PRIMARY KEY(id_entretien, id_recruteur))');
        $this->addSql('CREATE INDEX IDX_21864B7AB6D6AFD ON entretien_recruteur (id_entretien)');
        $this->addSql('CREATE INDEX IDX_21864B7ABE6DBAB ON entretien_recruteur (id_recruteur)');
        $this->addSql('CREATE TABLE etape_recrutement (id VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, niveau SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE etape_recrutement_candidat (id_candidat VARCHAR(255) NOT NULL, id_etape_recrutement VARCHAR(255) NOT NULL, id_offre_emploi INT NOT NULL, motif TEXT DEFAULT NULL, date_heure TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id_candidat, id_etape_recrutement, id_offre_emploi))');
        $this->addSql('CREATE INDEX IDX_4E0518C93A6E58E4 ON etape_recrutement_candidat (id_candidat)');
        $this->addSql('CREATE INDEX IDX_4E0518C9B631CE3D ON etape_recrutement_candidat (id_etape_recrutement)');
        $this->addSql('CREATE INDEX IDX_4E0518C930EBA5A3 ON etape_recrutement_candidat (id_offre_emploi)');
        $this->addSql('CREATE TABLE evaluation (id VARCHAR(255) NOT NULL, utilisateur_id VARCHAR(255) NOT NULL, juge_id VARCHAR(255) NOT NULL, date_evaluation DATE NOT NULL, score_moyenne NUMERIC(5, 2) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1323A575FB88E14F ON evaluation (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_1323A57557AFE0E9 ON evaluation (juge_id)');
        $this->addSql('CREATE TABLE feedback (evaluation_id VARCHAR(255) NOT NULL, positif_avis TEXT DEFAULT NULL, critique_avis TEXT DEFAULT NULL, PRIMARY KEY(evaluation_id))');
        $this->addSql('CREATE TABLE offre_emploi (id SERIAL NOT NULL, id_poste VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT NOT NULL, salaire_minimum NUMERIC(18, 2) DEFAULT NULL, salaire_maximum NUMERIC(18, 2) DEFAULT NULL, date_heure_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_expiration DATE DEFAULT NULL, statut VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_132AD0D1920C4E9B ON offre_emploi (id_poste)');
        $this->addSql('CREATE TABLE poste (id VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, responsabilites TEXT NOT NULL, exigences TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE type_conge (id VARCHAR(255) NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE type_contrat (id VARCHAR(255) NOT NULL, designation VARCHAR(255) NOT NULL, duree_minimum SMALLINT DEFAULT NULL, duree_maximum SMALLINT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE utilisateur (id VARCHAR(255) NOT NULL, id_departement VARCHAR(255) NOT NULL, id_poste VARCHAR(255) NOT NULL, id_contrat VARCHAR(255) NOT NULL, nom VARCHAR(70) NOT NULL, prenom VARCHAR(70) NOT NULL, email VARCHAR(180) NOT NULL, telephone VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, salaire NUMERIC(18, 2) NOT NULL, debut_activite DATE NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1D1C63B3D9649694 ON utilisateur (id_departement)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3920C4E9B ON utilisateur (id_poste)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3BEA930E3 ON utilisateur (id_contrat)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON utilisateur (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE candidat_offre_emploi ADD CONSTRAINT FK_B1E2339A8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE candidat_offre_emploi ADD CONSTRAINT FK_B1E2339AB08996ED FOREIGN KEY (offre_emploi_id) REFERENCES offre_emploi (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993C54C8C93 FOREIGN KEY (type_id) REFERENCES type_contrat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demande_conge ADD CONSTRAINT FK_D806106150EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demande_conge ADD CONSTRAINT FK_D8061061855E9468 FOREIGN KEY (id_type_conge) REFERENCES type_conge (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE detail_evaluation ADD CONSTRAINT FK_A83915A3456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entretien ADD CONSTRAINT FK_2B58D6DA8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entretien_recruteur ADD CONSTRAINT FK_21864B7AB6D6AFD FOREIGN KEY (id_entretien) REFERENCES entretien (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entretien_recruteur ADD CONSTRAINT FK_21864B7ABE6DBAB FOREIGN KEY (id_recruteur) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE etape_recrutement_candidat ADD CONSTRAINT FK_4E0518C93A6E58E4 FOREIGN KEY (id_candidat) REFERENCES candidat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE etape_recrutement_candidat ADD CONSTRAINT FK_4E0518C9B631CE3D FOREIGN KEY (id_etape_recrutement) REFERENCES etape_recrutement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE etape_recrutement_candidat ADD CONSTRAINT FK_4E0518C930EBA5A3 FOREIGN KEY (id_offre_emploi) REFERENCES offre_emploi (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A57557AFE0E9 FOREIGN KEY (juge_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre_emploi ADD CONSTRAINT FK_132AD0D1920C4E9B FOREIGN KEY (id_poste) REFERENCES poste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3D9649694 FOREIGN KEY (id_departement) REFERENCES departement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3920C4E9B FOREIGN KEY (id_poste) REFERENCES poste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3BEA930E3 FOREIGN KEY (id_contrat) REFERENCES contrat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE candidat_offre_emploi DROP CONSTRAINT FK_B1E2339A8D0EB82');
        $this->addSql('ALTER TABLE candidat_offre_emploi DROP CONSTRAINT FK_B1E2339AB08996ED');
        $this->addSql('ALTER TABLE contrat DROP CONSTRAINT FK_60349993C54C8C93');
        $this->addSql('ALTER TABLE demande_conge DROP CONSTRAINT FK_D806106150EAE44');
        $this->addSql('ALTER TABLE demande_conge DROP CONSTRAINT FK_D8061061855E9468');
        $this->addSql('ALTER TABLE detail_evaluation DROP CONSTRAINT FK_A83915A3456C5646');
        $this->addSql('ALTER TABLE entretien DROP CONSTRAINT FK_2B58D6DA8D0EB82');
        $this->addSql('ALTER TABLE entretien_recruteur DROP CONSTRAINT FK_21864B7AB6D6AFD');
        $this->addSql('ALTER TABLE entretien_recruteur DROP CONSTRAINT FK_21864B7ABE6DBAB');
        $this->addSql('ALTER TABLE etape_recrutement_candidat DROP CONSTRAINT FK_4E0518C93A6E58E4');
        $this->addSql('ALTER TABLE etape_recrutement_candidat DROP CONSTRAINT FK_4E0518C9B631CE3D');
        $this->addSql('ALTER TABLE etape_recrutement_candidat DROP CONSTRAINT FK_4E0518C930EBA5A3');
        $this->addSql('ALTER TABLE evaluation DROP CONSTRAINT FK_1323A575FB88E14F');
        $this->addSql('ALTER TABLE evaluation DROP CONSTRAINT FK_1323A57557AFE0E9');
        $this->addSql('ALTER TABLE feedback DROP CONSTRAINT FK_D2294458456C5646');
        $this->addSql('ALTER TABLE offre_emploi DROP CONSTRAINT FK_132AD0D1920C4E9B');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B3D9649694');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B3920C4E9B');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B3BEA930E3');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE candidat_offre_emploi');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('DROP TABLE demande_conge');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE detail_evaluation');
        $this->addSql('DROP TABLE entretien');
        $this->addSql('DROP TABLE entretien_recruteur');
        $this->addSql('DROP TABLE etape_recrutement');
        $this->addSql('DROP TABLE etape_recrutement_candidat');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE offre_emploi');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP TABLE type_conge');
        $this->addSql('DROP TABLE type_contrat');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
