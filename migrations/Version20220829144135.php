<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220829144135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dive_type (dive_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_E87AD4412E04E766 (dive_id), INDEX IDX_E87AD441C54C8C93 (type_id), PRIMARY KEY(dive_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dive_type ADD CONSTRAINT FK_E87AD4412E04E766 FOREIGN KEY (dive_id) REFERENCES dive (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dive_type ADD CONSTRAINT FK_E87AD441C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dive ADD environment_id INT NOT NULL, ADD role_id INT NOT NULL, ADD uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE dive ADD CONSTRAINT FK_96BB0440903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id)');
        $this->addSql('ALTER TABLE dive ADD CONSTRAINT FK_96BB0440D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_96BB0440903E3A94 ON dive (environment_id)');
        $this->addSql('CREATE INDEX IDX_96BB0440D60322AC ON dive (role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dive_type DROP FOREIGN KEY FK_E87AD4412E04E766');
        $this->addSql('ALTER TABLE dive_type DROP FOREIGN KEY FK_E87AD441C54C8C93');
        $this->addSql('DROP TABLE dive_type');
        $this->addSql('ALTER TABLE dive DROP FOREIGN KEY FK_96BB0440903E3A94');
        $this->addSql('ALTER TABLE dive DROP FOREIGN KEY FK_96BB0440D60322AC');
        $this->addSql('DROP INDEX IDX_96BB0440903E3A94 ON dive');
        $this->addSql('DROP INDEX IDX_96BB0440D60322AC ON dive');
        $this->addSql('ALTER TABLE dive DROP environment_id, DROP role_id, DROP uuid, DROP created_at, DROP updated_at');
    }
}
