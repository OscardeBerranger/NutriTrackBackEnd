<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250311151900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profile_ingredient (profile_id INT NOT NULL, ingredient_id INT NOT NULL, PRIMARY KEY(profile_id, ingredient_id))');
        $this->addSql('CREATE INDEX IDX_ACC44F2DCCFA12B8 ON profile_ingredient (profile_id)');
        $this->addSql('CREATE INDEX IDX_ACC44F2D933FE08C ON profile_ingredient (ingredient_id)');
        $this->addSql('ALTER TABLE profile_ingredient ADD CONSTRAINT FK_ACC44F2DCCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile_ingredient ADD CONSTRAINT FK_ACC44F2D933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE profile_ingredient DROP CONSTRAINT FK_ACC44F2DCCFA12B8');
        $this->addSql('ALTER TABLE profile_ingredient DROP CONSTRAINT FK_ACC44F2D933FE08C');
        $this->addSql('DROP TABLE profile_ingredient');
    }
}
