<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261111193133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe ADD responsable_id INT NOT NULL');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA1553C59D72 FOREIGN KEY (responsable_id) REFERENCES inscription (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2449BA1553C59D72 ON equipe (responsable_id)');
        $this->addSql('ALTER TABLE inscription ADD equipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D66D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D66D861B89 ON inscription (equipe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA1553C59D72');
        $this->addSql('DROP INDEX UNIQ_2449BA1553C59D72 ON equipe');
        $this->addSql('ALTER TABLE equipe DROP responsable_id');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D66D861B89');
        $this->addSql('DROP INDEX IDX_5E90F6D66D861B89 ON inscription');
        $this->addSql('ALTER TABLE inscription DROP equipe_id');
    }
}
