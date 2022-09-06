<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901011118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fournisseur ADD zones_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32A6EAEB7A FOREIGN KEY (zones_id) REFERENCES zone (id)');
        $this->addSql('CREATE INDEX IDX_369ECA32A6EAEB7A ON fournisseur (zones_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32A6EAEB7A');
        $this->addSql('DROP INDEX IDX_369ECA32A6EAEB7A ON fournisseur');
        $this->addSql('ALTER TABLE fournisseur DROP zones_id');
    }
}
