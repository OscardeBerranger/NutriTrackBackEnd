<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250218144813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tracking (id SERIAL NOT NULL, of_prodile_id INT NOT NULL, date DATE DEFAULT NULL, consumed_calories DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A87C621CB231C204 ON tracking (of_prodile_id)');
        $this->addSql('ALTER TABLE tracking ADD CONSTRAINT FK_A87C621CB231C204 FOREIGN KEY (of_prodile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tracking DROP CONSTRAINT FK_A87C621CB231C204');
        $this->addSql('DROP TABLE tracking');
    }
}
