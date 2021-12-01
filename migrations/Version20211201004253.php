<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211201004253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adress (id INT AUTO_INCREMENT NOT NULL, department_id INT NOT NULL, street_number INT NOT NULL, street_name VARCHAR(255) NOT NULL, adress_complement VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, INDEX IDX_5CECC7BEAE80F5DF (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE announce (id INT AUTO_INCREMENT NOT NULL, picture_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, lot_number INT NOT NULL, published_at DATETIME NOT NULL, tax INT NOT NULL, UNIQUE INDEX UNIQ_E6D6DD75EE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE announce_game (announce_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_1A2252846F5DA3DE (announce_id), INDEX IDX_1A225284E48FD905 (game_id), PRIMARY KEY(announce_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE announce_user (announce_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B49AB5416F5DA3DE (announce_id), INDEX IDX_B49AB541A76ED395 (user_id), PRIMARY KEY(announce_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE announce_bid (id INT AUTO_INCREMENT NOT NULL, bid_id INT NOT NULL, announce_id INT NOT NULL, sold TINYINT(1) NOT NULL, starting_price NUMERIC(10, 2) NOT NULL, sold_at_price NUMERIC(10, 2) DEFAULT NULL, reserve_price NUMERIC(10, 2) NOT NULL, INDEX IDX_402279104D9866B8 (bid_id), INDEX IDX_402279106F5DA3DE (announce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auction_house (id INT AUTO_INCREMENT NOT NULL, adress_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_28C1A0948486F9AC (adress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bid (id INT AUTO_INCREMENT NOT NULL, auctioneer_id INT NOT NULL, adress_id INT DEFAULT NULL, start_hour DATETIME NOT NULL, end_hour DATETIME NOT NULL, INDEX IDX_4AF2B3F32533C6D7 (auctioneer_id), UNIQUE INDEX UNIQ_4AF2B3F38486F9AC (adress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_game (category_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_A8B04BCB12469DE2 (category_id), INDEX IDX_A8B04BCBE48FD905 (game_id), PRIMARY KEY(category_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_CD1DE18A98260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deposit_address (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, UNIQUE INDEX UNIQ_C8495DAF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL, INDEX IDX_8C9F3610E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, auctioneer_id INT DEFAULT NULL, deposit_address_id INT DEFAULT NULL, estimation NUMERIC(10, 2) DEFAULT NULL, for_sale TINYINT(1) NOT NULL, INDEX IDX_232B318C7E3C61F9 (owner_id), INDEX IDX_232B318C2533C6D7 (auctioneer_id), INDEX IDX_232B318CBC4CBC (deposit_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_order (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, announce_bid_id INT NOT NULL, amount NUMERIC(10, 2) NOT NULL, emission_time DATETIME NOT NULL, INDEX IDX_21E210B2A76ED395 (user_id), INDEX IDX_21E210B251FAE55B (announce_bid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_announce (tag_id INT NOT NULL, announce_id INT NOT NULL, INDEX IDX_D0E7A6AEBAD26311 (tag_id), INDEX IDX_D0E7A6AE6F5DA3DE (announce_id), PRIMARY KEY(tag_id, announce_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adress ADD CONSTRAINT FK_5CECC7BEAE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE announce ADD CONSTRAINT FK_E6D6DD75EE45BDBF FOREIGN KEY (picture_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE announce_game ADD CONSTRAINT FK_1A2252846F5DA3DE FOREIGN KEY (announce_id) REFERENCES announce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE announce_game ADD CONSTRAINT FK_1A225284E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE announce_user ADD CONSTRAINT FK_B49AB5416F5DA3DE FOREIGN KEY (announce_id) REFERENCES announce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE announce_user ADD CONSTRAINT FK_B49AB541A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE announce_bid ADD CONSTRAINT FK_402279104D9866B8 FOREIGN KEY (bid_id) REFERENCES bid (id)');
        $this->addSql('ALTER TABLE announce_bid ADD CONSTRAINT FK_402279106F5DA3DE FOREIGN KEY (announce_id) REFERENCES announce (id)');
        $this->addSql('ALTER TABLE auction_house ADD CONSTRAINT FK_28C1A0948486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id)');
        $this->addSql('ALTER TABLE bid ADD CONSTRAINT FK_4AF2B3F32533C6D7 FOREIGN KEY (auctioneer_id) REFERENCES auctioneer (id)');
        $this->addSql('ALTER TABLE bid ADD CONSTRAINT FK_4AF2B3F38486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id)');
        $this->addSql('ALTER TABLE category_game ADD CONSTRAINT FK_A8B04BCB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_game ADD CONSTRAINT FK_A8B04BCBE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE deposit_address ADD CONSTRAINT FK_C8495DAF5B7AF75 FOREIGN KEY (address_id) REFERENCES adress (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C2533C6D7 FOREIGN KEY (auctioneer_id) REFERENCES auctioneer (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CBC4CBC FOREIGN KEY (deposit_address_id) REFERENCES deposit_address (id)');
        $this->addSql('ALTER TABLE purchase_order ADD CONSTRAINT FK_21E210B2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE purchase_order ADD CONSTRAINT FK_21E210B251FAE55B FOREIGN KEY (announce_bid_id) REFERENCES announce_bid (id)');
        $this->addSql('ALTER TABLE tag_announce ADD CONSTRAINT FK_D0E7A6AEBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_announce ADD CONSTRAINT FK_D0E7A6AE6F5DA3DE FOREIGN KEY (announce_id) REFERENCES announce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE auctioneer ADD auction_house_id INT NOT NULL, ADD adress_id INT NOT NULL');
        $this->addSql('ALTER TABLE auctioneer ADD CONSTRAINT FK_26256AC5DE3F9BFB FOREIGN KEY (auction_house_id) REFERENCES auction_house (id)');
        $this->addSql('ALTER TABLE auctioneer ADD CONSTRAINT FK_26256AC58486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id)');
        $this->addSql('CREATE INDEX IDX_26256AC5DE3F9BFB ON auctioneer (auction_house_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_26256AC58486F9AC ON auctioneer (adress_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auction_house DROP FOREIGN KEY FK_28C1A0948486F9AC');
        $this->addSql('ALTER TABLE auctioneer DROP FOREIGN KEY FK_26256AC58486F9AC');
        $this->addSql('ALTER TABLE bid DROP FOREIGN KEY FK_4AF2B3F38486F9AC');
        $this->addSql('ALTER TABLE deposit_address DROP FOREIGN KEY FK_C8495DAF5B7AF75');
        $this->addSql('ALTER TABLE announce_game DROP FOREIGN KEY FK_1A2252846F5DA3DE');
        $this->addSql('ALTER TABLE announce_user DROP FOREIGN KEY FK_B49AB5416F5DA3DE');
        $this->addSql('ALTER TABLE announce_bid DROP FOREIGN KEY FK_402279106F5DA3DE');
        $this->addSql('ALTER TABLE tag_announce DROP FOREIGN KEY FK_D0E7A6AE6F5DA3DE');
        $this->addSql('ALTER TABLE purchase_order DROP FOREIGN KEY FK_21E210B251FAE55B');
        $this->addSql('ALTER TABLE auctioneer DROP FOREIGN KEY FK_26256AC5DE3F9BFB');
        $this->addSql('ALTER TABLE announce_bid DROP FOREIGN KEY FK_402279104D9866B8');
        $this->addSql('ALTER TABLE category_game DROP FOREIGN KEY FK_A8B04BCB12469DE2');
        $this->addSql('ALTER TABLE adress DROP FOREIGN KEY FK_5CECC7BEAE80F5DF');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CBC4CBC');
        $this->addSql('ALTER TABLE announce DROP FOREIGN KEY FK_E6D6DD75EE45BDBF');
        $this->addSql('ALTER TABLE announce_game DROP FOREIGN KEY FK_1A225284E48FD905');
        $this->addSql('ALTER TABLE category_game DROP FOREIGN KEY FK_A8B04BCBE48FD905');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610E48FD905');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18A98260155');
        $this->addSql('ALTER TABLE tag_announce DROP FOREIGN KEY FK_D0E7A6AEBAD26311');
        $this->addSql('DROP TABLE adress');
        $this->addSql('DROP TABLE announce');
        $this->addSql('DROP TABLE announce_game');
        $this->addSql('DROP TABLE announce_user');
        $this->addSql('DROP TABLE announce_bid');
        $this->addSql('DROP TABLE auction_house');
        $this->addSql('DROP TABLE bid');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_game');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE deposit_address');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE purchase_order');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_announce');
        $this->addSql('DROP INDEX IDX_26256AC5DE3F9BFB ON auctioneer');
        $this->addSql('DROP INDEX UNIQ_26256AC58486F9AC ON auctioneer');
        $this->addSql('ALTER TABLE auctioneer DROP auction_house_id, DROP adress_id');
    }
}
