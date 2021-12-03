<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211202164836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, department_id INT NOT NULL, bid_id INT DEFAULT NULL, street_number SMALLINT NOT NULL, street_name VARCHAR(255) NOT NULL, address_complement VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(5) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, INDEX IDX_D4E6F81AE80F5DF (department_id), UNIQUE INDEX UNIQ_D4E6F814D9866B8 (bid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F814D9866B8 FOREIGN KEY (bid_id) REFERENCES bid (id)');
        $this->addSql('ALTER TABLE auction_house ADD address_id INT NOT NULL');
        $this->addSql('ALTER TABLE auction_house ADD CONSTRAINT FK_28C1A094F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_28C1A094F5B7AF75 ON auction_house (address_id)');
        $this->addSql('ALTER TABLE deposit_address ADD address_id INT NOT NULL');
        $this->addSql('ALTER TABLE deposit_address ADD CONSTRAINT FK_C8495DAF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C8495DAF5B7AF75 ON deposit_address (address_id)');
        $this->addSql('ALTER TABLE game ADD title VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE person ADD address_id INT NOT NULL');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34DCD176F5B7AF75 ON person (address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auction_house DROP FOREIGN KEY FK_28C1A094F5B7AF75');
        $this->addSql('ALTER TABLE deposit_address DROP FOREIGN KEY FK_C8495DAF5B7AF75');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176F5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP INDEX UNIQ_28C1A094F5B7AF75 ON auction_house');
        $this->addSql('ALTER TABLE auction_house DROP address_id');
        $this->addSql('DROP INDEX UNIQ_C8495DAF5B7AF75 ON deposit_address');
        $this->addSql('ALTER TABLE deposit_address DROP address_id');
        $this->addSql('ALTER TABLE game DROP title, DROP description');
        $this->addSql('DROP INDEX UNIQ_34DCD176F5B7AF75 ON person');
        $this->addSql('ALTER TABLE person DROP address_id');
    }
}
