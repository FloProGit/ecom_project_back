<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308125028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, code INT NOT NULL, active TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, parent_category VARCHAR(255) NOT NULL, root_category INT NOT NULL, description VARCHAR(255) NOT NULL, meta_title VARCHAR(255) NOT NULL, meta_keywords VARCHAR(255) NOT NULL, meta_description VARCHAR(255) NOT NULL, url_rewritten VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, ext_id VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, attribute1 VARCHAR(255) DEFAULT NULL, attribute2 VARCHAR(255) DEFAULT NULL, value1 VARCHAR(255) DEFAULT NULL, value2 VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, brand INT NOT NULL, feature VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, pvp_bigbuy DOUBLE PRECISION NOT NULL, pvd DOUBLE PRECISION NOT NULL, iva INT NOT NULL, video INT NOT NULL, ean13 VARCHAR(255) NOT NULL, width DOUBLE PRECISION NOT NULL, height DOUBLE PRECISION NOT NULL, depth DOUBLE PRECISION NOT NULL, stock INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', image1 VARCHAR(500) DEFAULT NULL, image2 VARCHAR(500) DEFAULT NULL, image3 VARCHAR(500) DEFAULT NULL, image4 VARCHAR(500) DEFAULT NULL, image5 VARCHAR(500) DEFAULT NULL, image6 VARCHAR(500) DEFAULT NULL, image7 VARCHAR(500) DEFAULT NULL, image8 VARCHAR(500) DEFAULT NULL, `condition` VARCHAR(255) NOT NULL, intrastat INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
