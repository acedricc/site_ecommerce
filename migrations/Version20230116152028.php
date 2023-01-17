<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116152028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE info (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(20) NOT NULL, description LONGTEXT DEFAULT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie DROP genre, DROP couleur, DROP marque');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE info');
        $this->addSql('ALTER TABLE categorie ADD genre VARCHAR(20) NOT NULL, ADD couleur VARCHAR(20) NOT NULL, ADD marque VARCHAR(20) NOT NULL');
    }
}
