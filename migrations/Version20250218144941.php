<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250218144941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tracking DROP CONSTRAINT fk_a87c621cb231c204');
        $this->addSql('DROP INDEX uniq_a87c621cb231c204');
        $this->addSql('ALTER TABLE tracking RENAME COLUMN of_prodile_id TO of_profile_id');
        $this->addSql('ALTER TABLE tracking ADD CONSTRAINT FK_A87C621C25AED32D FOREIGN KEY (of_profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A87C621C25AED32D ON tracking (of_profile_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tracking DROP CONSTRAINT FK_A87C621C25AED32D');
        $this->addSql('DROP INDEX UNIQ_A87C621C25AED32D');
        $this->addSql('ALTER TABLE tracking RENAME COLUMN of_profile_id TO of_prodile_id');
        $this->addSql('ALTER TABLE tracking ADD CONSTRAINT fk_a87c621cb231c204 FOREIGN KEY (of_prodile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_a87c621cb231c204 ON tracking (of_prodile_id)');
    }
}
