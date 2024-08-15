<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240814201402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_products DROP FOREIGN KEY FK_5242B8EBA35F2858');
        $this->addSql('DROP INDEX IDX_5242B8EBA35F2858 ON order_products');
        $this->addSql('ALTER TABLE order_products ADD order_id INT DEFAULT NULL, DROP _order_id, CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_products ADD CONSTRAINT FK_5242B8EB8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_5242B8EB8D9F6D38 ON order_products (order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_products DROP FOREIGN KEY FK_5242B8EB8D9F6D38');
        $this->addSql('DROP INDEX IDX_5242B8EB8D9F6D38 ON order_products');
        $this->addSql('ALTER TABLE order_products ADD _order_id INT NOT NULL, DROP order_id, CHANGE product_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_products ADD CONSTRAINT FK_5242B8EBA35F2858 FOREIGN KEY (_order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_5242B8EBA35F2858 ON order_products (_order_id)');
    }
}
