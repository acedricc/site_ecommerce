<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217152349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE taille_produit (taille_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_FBC8E602FF25611A (taille_id), INDEX IDX_FBC8E602F347EFB (produit_id), PRIMARY KEY(taille_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE taille_produit ADD CONSTRAINT FK_FBC8E602FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_produit ADD CONSTRAINT FK_FBC8E602F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_taille DROP FOREIGN KEY FK_81024002F347EFB');
        $this->addSql('ALTER TABLE produit_taille DROP FOREIGN KEY FK_81024002FF25611A');
        $this->addSql('DROP TABLE produit_taille');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit_taille (produit_id INT NOT NULL, taille_id INT NOT NULL, INDEX IDX_81024002F347EFB (produit_id), INDEX IDX_81024002FF25611A (taille_id), PRIMARY KEY(produit_id, taille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE produit_taille ADD CONSTRAINT FK_81024002F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_taille ADD CONSTRAINT FK_81024002FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_produit DROP FOREIGN KEY FK_FBC8E602FF25611A');
        $this->addSql('ALTER TABLE taille_produit DROP FOREIGN KEY FK_FBC8E602F347EFB');
        $this->addSql('DROP TABLE taille_produit');
    }
}
