<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308144555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE ext_id ext_id VARCHAR(255) DEFAULT NULL, CHANGE category category VARCHAR(255) DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE brand brand INT DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL, CHANGE pvp_bigbuy pvp_bigbuy DOUBLE PRECISION DEFAULT NULL, CHANGE pvd pvd DOUBLE PRECISION DEFAULT NULL, CHANGE iva iva INT DEFAULT NULL, CHANGE video video INT DEFAULT NULL, CHANGE width width DOUBLE PRECISION DEFAULT NULL, CHANGE height height DOUBLE PRECISION DEFAULT NULL, CHANGE depth depth DOUBLE PRECISION DEFAULT NULL, CHANGE stock stock INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE `condition` `condition` VARCHAR(255) DEFAULT NULL, CHANGE intrastat intrastat INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE ext_id ext_id VARCHAR(255) NOT NULL, CHANGE category category VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE brand brand INT NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL, CHANGE pvp_bigbuy pvp_bigbuy DOUBLE PRECISION NOT NULL, CHANGE pvd pvd DOUBLE PRECISION NOT NULL, CHANGE iva iva INT NOT NULL, CHANGE video video INT NOT NULL, CHANGE width width DOUBLE PRECISION NOT NULL, CHANGE height height DOUBLE PRECISION NOT NULL, CHANGE depth depth DOUBLE PRECISION NOT NULL, CHANGE stock stock INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE `condition` `condition` VARCHAR(255) NOT NULL, CHANGE intrastat intrastat INT NOT NULL');
    }
}
