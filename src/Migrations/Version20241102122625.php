<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241102122625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abenmada_product_slug_history (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, slug VARCHAR(255) NOT NULL, locale VARCHAR(255) DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, INDEX IDX_CF5102BF4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE abenmada_taxon_slug_history (id INT AUTO_INCREMENT NOT NULL, taxon_id INT NOT NULL, slug VARCHAR(255) NOT NULL, locale VARCHAR(255) DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, INDEX IDX_C68495BADE13F470 (taxon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abenmada_product_slug_history ADD CONSTRAINT FK_CF5102BF4584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id)');
        $this->addSql('ALTER TABLE abenmada_taxon_slug_history ADD CONSTRAINT FK_C68495BADE13F470 FOREIGN KEY (taxon_id) REFERENCES sylius_taxon (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abenmada_product_slug_history DROP FOREIGN KEY FK_CF5102BF4584665A');
        $this->addSql('ALTER TABLE abenmada_taxon_slug_history DROP FOREIGN KEY FK_C68495BADE13F470');
        $this->addSql('DROP TABLE abenmada_product_slug_history');
        $this->addSql('DROP TABLE abenmada_taxon_slug_history');
    }
}
