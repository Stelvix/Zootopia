<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251105150839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animaux (id INT AUTO_INCREMENT NOT NULL, enclos_id INT NOT NULL, numero_identification VARCHAR(14) NOT NULL, nom VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, date_arrivee_au_zoo DATE NOT NULL, date_de_depart_du_zoo DATE DEFAULT NULL, le_zoo_en_es_proprietaire TINYINT(1) NOT NULL, genre VARCHAR(50) NOT NULL, espece VARCHAR(50) NOT NULL, sexe VARCHAR(255) NOT NULL, sterilise TINYINT(1) NOT NULL, es_en_quarantaine TINYINT(1) DEFAULT NULL, INDEX IDX_9ABE194DB1C0859 (enclos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enclos (id INT AUTO_INCREMENT NOT NULL, espace_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, superficie DOUBLE PRECISION NOT NULL, capaciteMax INT NOT NULL, INDEX IDX_8CCECB21B6885C6C (espace_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE espace (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, superficie DOUBLE PRECISION NOT NULL, date_ouverture DATE DEFAULT NULL, date_fermeture DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194DB1C0859 FOREIGN KEY (enclos_id) REFERENCES enclos (id)');
        $this->addSql('ALTER TABLE enclos ADD CONSTRAINT FK_8CCECB21B6885C6C FOREIGN KEY (espace_id) REFERENCES espace (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194DB1C0859');
        $this->addSql('ALTER TABLE enclos DROP FOREIGN KEY FK_8CCECB21B6885C6C');
        $this->addSql('DROP TABLE animaux');
        $this->addSql('DROP TABLE enclos');
        $this->addSql('DROP TABLE espace');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
