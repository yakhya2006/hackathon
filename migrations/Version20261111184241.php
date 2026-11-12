<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261111184241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY `FK_2449BA15D4E271E1`');
        $this->addSql('DROP INDEX IDX_2449BA15D4E271E1 ON equipe');
        $this->addSql('ALTER TABLE equipe ADD projet_id INT NOT NULL, DROP projet_id_id');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_2449BA15C18272 ON equipe (projet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA15C18272');
        $this->addSql('DROP INDEX IDX_2449BA15C18272 ON equipe');
        $this->addSql('ALTER TABLE equipe ADD projet_id_id INT DEFAULT NULL, DROP projet_id');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT `FK_2449BA15D4E271E1` FOREIGN KEY (projet_id_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_2449BA15D4E271E1 ON equipe (projet_id_id)');
    }
}
