<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425103257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribute (id INT AUTO_INCREMENT NOT NULL, product_variation_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_FA7AEFFBB7BBF40F (product_variation_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discount (id INT AUTO_INCREMENT NOT NULL, value DOUBLE PRECISION NOT NULL, discount_from DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', discount_to DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manufacter (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_url (id INT AUTO_INCREMENT NOT NULL, product_variation_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, url_link VARCHAR(500) NOT NULL, mime_type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_BF273753B7BBF40F (product_variation_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_variation (id INT AUTO_INCREMENT NOT NULL, product_id_id INT NOT NULL, manufacter_id_id INT DEFAULT NULL, discount_id_id INT DEFAULT NULL, ext_id VARCHAR(255) NOT NULL, quantity INT NOT NULL, minimal_quantity INT NOT NULL, ean13 VARCHAR(255) NOT NULL, wholesale_price DOUBLE PRECISION NOT NULL, on_sale TINYINT(1) NOT NULL, description LONGTEXT DEFAULT NULL, price_tax_exclude DOUBLE PRECISION NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C3B8567DE18E50B (product_id_id), INDEX IDX_C3B8567A1001EB1 (manufacter_id_id), UNIQUE INDEX UNIQ_C3B8567546E46C0 (discount_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tax_rule (id INT AUTO_INCREMENT NOT NULL, code_tax INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribute ADD CONSTRAINT FK_FA7AEFFBB7BBF40F FOREIGN KEY (product_variation_id_id) REFERENCES product_variation (id)');
        $this->addSql('ALTER TABLE media_url ADD CONSTRAINT FK_BF273753B7BBF40F FOREIGN KEY (product_variation_id_id) REFERENCES product_variation (id)');
        $this->addSql('ALTER TABLE product_variation ADD CONSTRAINT FK_C3B8567DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_variation ADD CONSTRAINT FK_C3B8567A1001EB1 FOREIGN KEY (manufacter_id_id) REFERENCES manufacter (id)');
        $this->addSql('ALTER TABLE product_variation ADD CONSTRAINT FK_C3B8567546E46C0 FOREIGN KEY (discount_id_id) REFERENCES discount (id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD916722FD');
        $this->addSql('DROP INDEX IDX_D34A04AD916722FD ON product');
        $this->addSql('ALTER TABLE product DROP attribute_1, DROP attribute_2, DROP value_1, DROP value_2, DROP description, DROP brand, DROP feature, DROP price, DROP pvp, DROP pvd, DROP iva, DROP video, DROP ean13, DROP image_1, DROP image_2, DROP image_3, DROP image_4, DROP image_5, DROP image_6, DROP image_7, DROP image_8, DROP intrastat, DROP stock, CHANGE condition_product_id_id tax_rule_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD6AE14E4B FOREIGN KEY (tax_rule_id_id) REFERENCES tax_rule (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD6AE14E4B ON product (tax_rule_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD6AE14E4B');
        $this->addSql('ALTER TABLE attribute DROP FOREIGN KEY FK_FA7AEFFBB7BBF40F');
        $this->addSql('ALTER TABLE media_url DROP FOREIGN KEY FK_BF273753B7BBF40F');
        $this->addSql('ALTER TABLE product_variation DROP FOREIGN KEY FK_C3B8567DE18E50B');
        $this->addSql('ALTER TABLE product_variation DROP FOREIGN KEY FK_C3B8567A1001EB1');
        $this->addSql('ALTER TABLE product_variation DROP FOREIGN KEY FK_C3B8567546E46C0');
        $this->addSql('DROP TABLE attribute');
        $this->addSql('DROP TABLE discount');
        $this->addSql('DROP TABLE manufacter');
        $this->addSql('DROP TABLE media_url');
        $this->addSql('DROP TABLE product_variation');
        $this->addSql('DROP TABLE tax_rule');
        $this->addSql('DROP INDEX IDX_D34A04AD6AE14E4B ON product');
        $this->addSql('ALTER TABLE product ADD attribute_1 VARCHAR(255) DEFAULT NULL, ADD attribute_2 VARCHAR(255) DEFAULT NULL, ADD value_1 VARCHAR(255) DEFAULT NULL, ADD value_2 VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT NOT NULL, ADD brand INT NOT NULL, ADD feature VARCHAR(255) DEFAULT NULL, ADD price DOUBLE PRECISION NOT NULL, ADD pvp DOUBLE PRECISION NOT NULL, ADD pvd DOUBLE PRECISION NOT NULL, ADD iva INT NOT NULL, ADD video VARCHAR(255) NOT NULL, ADD ean13 INT NOT NULL, ADD image_1 VARCHAR(255) DEFAULT NULL, ADD image_2 VARCHAR(255) DEFAULT NULL, ADD image_3 VARCHAR(255) DEFAULT NULL, ADD image_4 VARCHAR(255) DEFAULT NULL, ADD image_5 VARCHAR(255) DEFAULT NULL, ADD image_6 VARCHAR(255) DEFAULT NULL, ADD image_7 VARCHAR(255) DEFAULT NULL, ADD image_8 VARCHAR(255) DEFAULT NULL, ADD intrastat INT NOT NULL, ADD stock INT NOT NULL, CHANGE tax_rule_id_id condition_product_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD916722FD FOREIGN KEY (condition_product_id_id) REFERENCES condition_product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D34A04AD916722FD ON product (condition_product_id_id)');
    }
}
