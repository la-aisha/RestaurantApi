<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901000759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom_fournisseur VARCHAR(255) NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur_categorie (fournisseur_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_B4B79A51670C757F (fournisseur_id), INDEX IDX_B4B79A51BCF5E72D (categorie_id), PRIMARY KEY(fournisseur_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, nom_zone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fournisseur_categorie ADD CONSTRAINT FK_B4B79A51670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_categorie ADD CONSTRAINT FK_B4B79A51BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fournisseur_categorie DROP FOREIGN KEY FK_B4B79A51670C757F');
        $this->addSql('ALTER TABLE fournisseur_categorie DROP FOREIGN KEY FK_B4B79A51BCF5E72D');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE fournisseur_categorie');
        $this->addSql('DROP TABLE zone');
    }
}
