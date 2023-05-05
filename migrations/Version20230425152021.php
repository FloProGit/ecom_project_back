<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425152021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribute (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, is_active TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, id_parent INT NOT NULL, parent VARCHAR(255) NOT NULL, root_category INT NOT NULL, description LONGTEXT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_keyword VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', code INT NOT NULL, url_rewritten VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE condition_product (id INT AUTO_INCREMENT NOT NULL, current_condition VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discount (id INT AUTO_INCREMENT NOT NULL, value DOUBLE PRECISION NOT NULL, discount_from DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', discount_to DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manufacter (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, ext_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_url (id INT AUTO_INCREMENT NOT NULL, product_variation_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, url_link VARCHAR(500) NOT NULL, mime_type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_BF273753DC269DB3 (product_variation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, tax_rule_id INT DEFAULT NULL, ext_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, width DOUBLE PRECISION NOT NULL, height DOUBLE PRECISION NOT NULL, depth DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ext_reference VARCHAR(255) NOT NULL, has_variation TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, short_description VARCHAR(255) NOT NULL, INDEX IDX_D34A04AD3506A35B (tax_rule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (product_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_CDFC73564584665A (product_id), INDEX IDX_CDFC735612469DE2 (category_id), PRIMARY KEY(product_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_variation (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, manufacter_id INT DEFAULT NULL, discount_id INT DEFAULT NULL, condition_product_id INT DEFAULT NULL, attribute_id INT DEFAULT NULL, ext_id VARCHAR(255) NOT NULL, quantity INT NOT NULL, minimal_quantity INT NOT NULL, ean13 VARCHAR(255) NOT NULL, wholesale_price DOUBLE PRECISION NOT NULL, on_sale TINYINT(1) NOT NULL, price_tax_exclude DOUBLE PRECISION NOT NULL, name VARCHAR(255) NOT NULL, ext_reference VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_main TINYINT(1) NOT NULL, INDEX IDX_C3B85674584665A (product_id), INDEX IDX_C3B8567F7AFE28B (manufacter_id), UNIQUE INDEX UNIQ_C3B85674C7C611F (discount_id), INDEX IDX_C3B8567B6595BFC (condition_product_id), UNIQUE INDEX UNIQ_C3B8567B6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tax_rule (id INT AUTO_INCREMENT NOT NULL, code_tax INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email_verified_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE media_url ADD CONSTRAINT FK_BF273753DC269DB3 FOREIGN KEY (product_variation_id) REFERENCES product_variation (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD3506A35B FOREIGN KEY (tax_rule_id) REFERENCES tax_rule (id)');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC73564584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC735612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_variation ADD CONSTRAINT FK_C3B85674584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_variation ADD CONSTRAINT FK_C3B8567F7AFE28B FOREIGN KEY (manufacter_id) REFERENCES manufacter (id)');
        $this->addSql('ALTER TABLE product_variation ADD CONSTRAINT FK_C3B85674C7C611F FOREIGN KEY (discount_id) REFERENCES discount (id)');
        $this->addSql('ALTER TABLE product_variation ADD CONSTRAINT FK_C3B8567B6595BFC FOREIGN KEY (condition_product_id) REFERENCES condition_product (id)');
        $this->addSql('ALTER TABLE product_variation ADD CONSTRAINT FK_C3B8567B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media_url DROP FOREIGN KEY FK_BF273753DC269DB3');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3506A35B');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC73564584665A');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC735612469DE2');
        $this->addSql('ALTER TABLE product_variation DROP FOREIGN KEY FK_C3B85674584665A');
        $this->addSql('ALTER TABLE product_variation DROP FOREIGN KEY FK_C3B8567F7AFE28B');
        $this->addSql('ALTER TABLE product_variation DROP FOREIGN KEY FK_C3B85674C7C611F');
        $this->addSql('ALTER TABLE product_variation DROP FOREIGN KEY FK_C3B8567B6595BFC');
        $this->addSql('ALTER TABLE product_variation DROP FOREIGN KEY FK_C3B8567B6E62EFA');
        $this->addSql('DROP TABLE attribute');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE condition_product');
        $this->addSql('DROP TABLE discount');
        $this->addSql('DROP TABLE manufacter');
        $this->addSql('DROP TABLE media_url');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE product_variation');
        $this->addSql('DROP TABLE tax_rule');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
