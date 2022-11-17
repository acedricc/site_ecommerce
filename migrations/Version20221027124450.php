<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221027124450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(20) NOT NULL, categorie VARCHAR(20) DEFAULT NULL, titre VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, prix NUMERIC(12, 2) NOT NULL, stock INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD email VARCHAR(255) DEFAULT NULL, ADD nom VARCHAR(20) DEFAULT NULL, ADD prenom VARCHAR(20) DEFAULT NULL, ADD adresse VARCHAR(100) DEFAULT NULL, ADD civilite VARCHAR(1) DEFAULT NULL, ADD code_postal VARCHAR(5) DEFAULT NULL, ADD ville VARCHAR(30) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE produit');
        $this->addSql('ALTER TABLE `user` DROP email, DROP nom, DROP prenom, DROP adresse, DROP civilite, DROP code_postal, DROP ville');
    }
}
