<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230311161555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE condition_product (id INT AUTO_INCREMENT NOT NULL, current_condition VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD condition_product_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD916722FD FOREIGN KEY (condition_product_id_id) REFERENCES condition_product (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD916722FD ON product (condition_product_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD916722FD');
        $this->addSql('DROP TABLE condition_product');
        $this->addSql('DROP INDEX IDX_D34A04AD916722FD ON product');
        $this->addSql('ALTER TABLE product DROP condition_product_id_id');
    }
}
