<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211206103057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, bid_id INT DEFAULT NULL, city_id INT NOT NULL, street_number SMALLINT NOT NULL, street_name VARCHAR(255) NOT NULL, address_complement VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D4E6F814D9866B8 (bid_id), INDEX IDX_D4E6F818BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auction_house (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_28C1A094F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auctioneer (id INT NOT NULL, auction_house_id INT NOT NULL, voluntary TINYINT(1) NOT NULL, INDEX IDX_26256AC5DE3F9BFB (auction_house_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bid (id INT AUTO_INCREMENT NOT NULL, auctioneer_id INT DEFAULT NULL, address_id INT DEFAULT NULL, start_hour DATETIME NOT NULL, end_hour DATETIME NOT NULL, INDEX IDX_4AF2B3F32533C6D7 (auctioneer_id), UNIQUE INDEX UNIQ_4AF2B3F3F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_game (category_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_A8B04BCB12469DE2 (category_id), INDEX IDX_A8B04BCBE48FD905 (game_id), PRIMARY KEY(category_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, department_id INT NOT NULL, name VARCHAR(255) NOT NULL, postal_code VARCHAR(5) NOT NULL, INDEX IDX_2D5B0234AE80F5DF (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_CD1DE18A98260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deposit_address (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, UNIQUE INDEX UNIQ_C8495DAF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, file_path VARCHAR(255) NOT NULL, INDEX IDX_8C9F3610E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, auctioneer_id INT DEFAULT NULL, deposit_address_id INT DEFAULT NULL, estimation NUMERIC(10, 2) DEFAULT NULL, for_sale TINYINT(1) DEFAULT \'0\' NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, invisble_for VARCHAR(255) DEFAULT NULL, INDEX IDX_232B318C7E3C61F9 (owner_id), INDEX IDX_232B318C2533C6D7 (auctioneer_id), INDEX IDX_232B318CBC4CBC (deposit_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE individual (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, desactivated TINYINT(1) DEFAULT \'0\' NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8793FC17E7927C74 (email), UNIQUE INDEX UNIQ_8793FC17F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_order (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, sale_bid_id INT DEFAULT NULL, amount NUMERIC(10, 2) NOT NULL, emission_time DATETIME NOT NULL, INDEX IDX_21E210B2A76ED395 (user_id), INDEX IDX_21E210B239F9687A (sale_bid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale (id INT AUTO_INCREMENT NOT NULL, picture_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, lot_number INT NOT NULL, published_at DATETIME NOT NULL, tax INT NOT NULL, UNIQUE INDEX UNIQ_E54BC005EE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_game (sale_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_9F6545694A7E4868 (sale_id), INDEX IDX_9F654569E48FD905 (game_id), PRIMARY KEY(sale_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_user (sale_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_31DDA2AC4A7E4868 (sale_id), INDEX IDX_31DDA2ACA76ED395 (user_id), PRIMARY KEY(sale_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_tag (sale_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_2B7E48324A7E4868 (sale_id), INDEX IDX_2B7E4832BAD26311 (tag_id), PRIMARY KEY(sale_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_bid (id INT AUTO_INCREMENT NOT NULL, bid_id INT NOT NULL, sale_id INT NOT NULL, sold TINYINT(1) NOT NULL, starting_price NUMERIC(10, 2) NOT NULL, reserve_price NUMERIC(10, 2) NOT NULL, INDEX IDX_62054C424D9866B8 (bid_id), INDEX IDX_62054C424A7E4868 (sale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT NOT NULL, birth_date DATE NOT NULL, verified TINYINT(1) DEFAULT \'0\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F814D9866B8 FOREIGN KEY (bid_id) REFERENCES bid (id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F818BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE auction_house ADD CONSTRAINT FK_28C1A094F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE auctioneer ADD CONSTRAINT FK_26256AC5DE3F9BFB FOREIGN KEY (auction_house_id) REFERENCES auction_house (id)');
        $this->addSql('ALTER TABLE auctioneer ADD CONSTRAINT FK_26256AC5BF396750 FOREIGN KEY (id) REFERENCES individual (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bid ADD CONSTRAINT FK_4AF2B3F32533C6D7 FOREIGN KEY (auctioneer_id) REFERENCES auctioneer (id)');
        $this->addSql('ALTER TABLE bid ADD CONSTRAINT FK_4AF2B3F3F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE category_game ADD CONSTRAINT FK_A8B04BCB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_game ADD CONSTRAINT FK_A8B04BCBE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE deposit_address ADD CONSTRAINT FK_C8495DAF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C2533C6D7 FOREIGN KEY (auctioneer_id) REFERENCES auctioneer (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CBC4CBC FOREIGN KEY (deposit_address_id) REFERENCES deposit_address (id)');
        $this->addSql('ALTER TABLE individual ADD CONSTRAINT FK_8793FC17F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE purchase_order ADD CONSTRAINT FK_21E210B2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE purchase_order ADD CONSTRAINT FK_21E210B239F9687A FOREIGN KEY (sale_bid_id) REFERENCES sale_bid (id)');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC005EE45BDBF FOREIGN KEY (picture_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE sale_game ADD CONSTRAINT FK_9F6545694A7E4868 FOREIGN KEY (sale_id) REFERENCES sale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sale_game ADD CONSTRAINT FK_9F654569E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sale_user ADD CONSTRAINT FK_31DDA2AC4A7E4868 FOREIGN KEY (sale_id) REFERENCES sale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sale_user ADD CONSTRAINT FK_31DDA2ACA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sale_tag ADD CONSTRAINT FK_2B7E48324A7E4868 FOREIGN KEY (sale_id) REFERENCES sale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sale_tag ADD CONSTRAINT FK_2B7E4832BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sale_bid ADD CONSTRAINT FK_62054C424D9866B8 FOREIGN KEY (bid_id) REFERENCES bid (id)');
        $this->addSql('ALTER TABLE sale_bid ADD CONSTRAINT FK_62054C424A7E4868 FOREIGN KEY (sale_id) REFERENCES sale (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BF396750 FOREIGN KEY (id) REFERENCES individual (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auction_house DROP FOREIGN KEY FK_28C1A094F5B7AF75');
        $this->addSql('ALTER TABLE bid DROP FOREIGN KEY FK_4AF2B3F3F5B7AF75');
        $this->addSql('ALTER TABLE deposit_address DROP FOREIGN KEY FK_C8495DAF5B7AF75');
        $this->addSql('ALTER TABLE individual DROP FOREIGN KEY FK_8793FC17F5B7AF75');
        $this->addSql('ALTER TABLE auctioneer DROP FOREIGN KEY FK_26256AC5DE3F9BFB');
        $this->addSql('ALTER TABLE bid DROP FOREIGN KEY FK_4AF2B3F32533C6D7');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C2533C6D7');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F814D9866B8');
        $this->addSql('ALTER TABLE sale_bid DROP FOREIGN KEY FK_62054C424D9866B8');
        $this->addSql('ALTER TABLE category_game DROP FOREIGN KEY FK_A8B04BCB12469DE2');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F818BAC62AF');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234AE80F5DF');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CBC4CBC');
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC005EE45BDBF');
        $this->addSql('ALTER TABLE category_game DROP FOREIGN KEY FK_A8B04BCBE48FD905');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610E48FD905');
        $this->addSql('ALTER TABLE sale_game DROP FOREIGN KEY FK_9F654569E48FD905');
        $this->addSql('ALTER TABLE auctioneer DROP FOREIGN KEY FK_26256AC5BF396750');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BF396750');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18A98260155');
        $this->addSql('ALTER TABLE sale_game DROP FOREIGN KEY FK_9F6545694A7E4868');
        $this->addSql('ALTER TABLE sale_user DROP FOREIGN KEY FK_31DDA2AC4A7E4868');
        $this->addSql('ALTER TABLE sale_tag DROP FOREIGN KEY FK_2B7E48324A7E4868');
        $this->addSql('ALTER TABLE sale_bid DROP FOREIGN KEY FK_62054C424A7E4868');
        $this->addSql('ALTER TABLE purchase_order DROP FOREIGN KEY FK_21E210B239F9687A');
        $this->addSql('ALTER TABLE sale_tag DROP FOREIGN KEY FK_2B7E4832BAD26311');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C7E3C61F9');
        $this->addSql('ALTER TABLE purchase_order DROP FOREIGN KEY FK_21E210B2A76ED395');
        $this->addSql('ALTER TABLE sale_user DROP FOREIGN KEY FK_31DDA2ACA76ED395');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE auction_house');
        $this->addSql('DROP TABLE auctioneer');
        $this->addSql('DROP TABLE bid');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_game');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE deposit_address');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE individual');
        $this->addSql('DROP TABLE purchase_order');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE sale');
        $this->addSql('DROP TABLE sale_game');
        $this->addSql('DROP TABLE sale_user');
        $this->addSql('DROP TABLE sale_tag');
        $this->addSql('DROP TABLE sale_bid');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
    }
}
