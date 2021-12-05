<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211205142415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F814D9866B8');
        $this->addSql('DROP INDEX UNIQ_D4E6F814D9866B8 ON address');
        $this->addSql('ALTER TABLE address DROP bid_id');
        $this->addSql('ALTER TABLE bid DROP FOREIGN KEY FK_4AF2B3F3F5B7AF75');
        $this->addSql('DROP INDEX UNIQ_4AF2B3F3F5B7AF75 ON bid');
        $this->addSql('ALTER TABLE bid DROP address_id, CHANGE auctioneer_id auctioneer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game CHANGE for_sale for_sale TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE invisble_for invisble_for VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE individual CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address ADD bid_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F814D9866B8 FOREIGN KEY (bid_id) REFERENCES bid (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D4E6F814D9866B8 ON address (bid_id)');
        $this->addSql('ALTER TABLE bid ADD address_id INT DEFAULT NULL, CHANGE auctioneer_id auctioneer_id INT NOT NULL');
        $this->addSql('ALTER TABLE bid ADD CONSTRAINT FK_4AF2B3F3F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4AF2B3F3F5B7AF75 ON bid (address_id)');
        $this->addSql('ALTER TABLE game CHANGE for_sale for_sale TINYINT(1) NOT NULL, CHANGE invisble_for invisble_for VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE individual CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
