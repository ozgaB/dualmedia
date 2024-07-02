<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702181525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dualmedia_order (id INT AUTO_INCREMENT NOT NULL, price_summary_gross NUMERIC(10, 2) NOT NULL, price_summary_net NUMERIC(10, 2) NOT NULL, products_amount INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dualmedia_order_product (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_CEE2E0938D9F6D38 (order_id), INDEX IDX_CEE2E0934584665A (product_id), UNIQUE INDEX order_product_unique (order_id, product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dualmedia_product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price NUMERIC(10, 2) NOT NULL, currency VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dualmedia_order_product ADD CONSTRAINT FK_CEE2E0938D9F6D38 FOREIGN KEY (order_id) REFERENCES dualmedia_order (id)');
        $this->addSql('ALTER TABLE dualmedia_order_product ADD CONSTRAINT FK_CEE2E0934584665A FOREIGN KEY (product_id) REFERENCES dualmedia_product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dualmedia_order_product DROP FOREIGN KEY FK_CEE2E0938D9F6D38');
        $this->addSql('ALTER TABLE dualmedia_order_product DROP FOREIGN KEY FK_CEE2E0934584665A');
        $this->addSql('DROP TABLE dualmedia_order');
        $this->addSql('DROP TABLE dualmedia_order_product');
        $this->addSql('DROP TABLE dualmedia_product');
    }
}
