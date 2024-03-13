<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240313192014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_8BF21CDE771C0C37 ON property');
        $this->addSql('ALTER TABLE property CHANGE sold sold TINYINT(1) DEFAULT false NOT NULL, CHANGE tap_id tag_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEBAD26311 FOREIGN KEY (tag_id) REFERENCES property_tag (id)');
        $this->addSql('CREATE INDEX IDX_8BF21CDEBAD26311 ON property (tag_id)');
        $this->addSql('ALTER TABLE property_option ADD CONSTRAINT FK_24F16FCC549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_option ADD CONSTRAINT FK_24F16FCCA7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEBAD26311');
        $this->addSql('DROP INDEX IDX_8BF21CDEBAD26311 ON property');
        $this->addSql('ALTER TABLE property CHANGE sold sold TINYINT(1) DEFAULT 0 NOT NULL, CHANGE tag_id tap_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_8BF21CDE771C0C37 ON property (tap_id)');
        $this->addSql('ALTER TABLE property_option DROP FOREIGN KEY FK_24F16FCC549213EC');
        $this->addSql('ALTER TABLE property_option DROP FOREIGN KEY FK_24F16FCCA7C41D6F');
    }
}
