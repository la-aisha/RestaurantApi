<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901010758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE element (id INT AUTO_INCREMENT NOT NULL, categories_id INT DEFAULT NULL, fournisseurs_id INT DEFAULT NULL, nom_el VARCHAR(255) NOT NULL, prix NUMERIC(10, 0) NOT NULL, description_el VARCHAR(255) NOT NULL, INDEX IDX_41405E39A21214B7 (categories_id), INDEX IDX_41405E3927ACDDFD (fournisseurs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE element ADD CONSTRAINT FK_41405E39A21214B7 FOREIGN KEY (categories_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE element ADD CONSTRAINT FK_41405E3927ACDDFD FOREIGN KEY (fournisseurs_id) REFERENCES fournisseur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE element DROP FOREIGN KEY FK_41405E39A21214B7');
        $this->addSql('ALTER TABLE element DROP FOREIGN KEY FK_41405E3927ACDDFD');
        $this->addSql('DROP TABLE element');
    }
}
