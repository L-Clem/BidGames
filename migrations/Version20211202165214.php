<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211202165214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bid ADD address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bid ADD CONSTRAINT FK_4AF2B3F3F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4AF2B3F3F5B7AF75 ON bid (address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bid DROP FOREIGN KEY FK_4AF2B3F3F5B7AF75');
        $this->addSql('DROP INDEX UNIQ_4AF2B3F3F5B7AF75 ON bid');
        $this->addSql('ALTER TABLE bid DROP address_id');
    }
}
