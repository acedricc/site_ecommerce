<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110143148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photos ADD images_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9D44F05E5 FOREIGN KEY (images_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_876E0D9D44F05E5 ON photos (images_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D9D44F05E5');
        $this->addSql('DROP INDEX IDX_876E0D9D44F05E5 ON photos');
        $this->addSql('ALTER TABLE photos DROP images_id');
    }
}
