<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250218152917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredient (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id SERIAL NOT NULL, calories DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product_ingredient (product_id INT NOT NULL, ingredient_id INT NOT NULL, PRIMARY KEY(product_id, ingredient_id))');
        $this->addSql('CREATE INDEX IDX_F8C8275B4584665A ON product_ingredient (product_id)');
        $this->addSql('CREATE INDEX IDX_F8C8275B933FE08C ON product_ingredient (ingredient_id)');
        $this->addSql('ALTER TABLE product_ingredient ADD CONSTRAINT FK_F8C8275B4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_ingredient ADD CONSTRAINT FK_F8C8275B933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product_ingredient DROP CONSTRAINT FK_F8C8275B4584665A');
        $this->addSql('ALTER TABLE product_ingredient DROP CONSTRAINT FK_F8C8275B933FE08C');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_ingredient');
    }
}
