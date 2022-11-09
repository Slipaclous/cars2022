<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221109141824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE marques (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(120) NOT NULL, cover LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voitures (id INT AUTO_INCREMENT NOT NULL, marque_id INT NOT NULL, modele VARCHAR(120) NOT NULL, km INT NOT NULL, prix DOUBLE PRECISION NOT NULL, cylindree DOUBLE PRECISION NOT NULL, puissance INT NOT NULL, carburant VARCHAR(120) NOT NULL, transmission VARCHAR(120) NOT NULL, annee_circulation DATE NOT NULL, nb_proprio INT NOT NULL, description LONGTEXT NOT NULL, option_car LONGTEXT DEFAULT NULL, INDEX IDX_8B58301B4827B9B2 (marque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voitures ADD CONSTRAINT FK_8B58301B4827B9B2 FOREIGN KEY (marque_id) REFERENCES marques (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voitures DROP FOREIGN KEY FK_8B58301B4827B9B2');
        $this->addSql('DROP TABLE marques');
        $this->addSql('DROP TABLE voitures');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
