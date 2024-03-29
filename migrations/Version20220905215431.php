<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220905215431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dive ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE dive ADD CONSTRAINT FK_96BB04407E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_96BB04407E3C61F9 ON dive (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dive DROP FOREIGN KEY FK_96BB04407E3C61F9');
        $this->addSql('DROP INDEX IDX_96BB04407E3C61F9 ON dive');
        $this->addSql('ALTER TABLE dive DROP owner_id');
    }
}
