<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901233137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dive (id INT AUTO_INCREMENT NOT NULL, environment_id INT NOT NULL, role_id INT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date DATETIME NOT NULL, total_time INT NOT NULL, max_depth DOUBLE PRECISION NOT NULL, gas JSON NOT NULL, INDEX IDX_96BB0440903E3A94 (environment_id), INDEX IDX_96BB0440D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dive_type (dive_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_E87AD4412E04E766 (dive_id), INDEX IDX_E87AD441C54C8C93 (type_id), PRIMARY KEY(dive_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE environment (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dive ADD CONSTRAINT FK_96BB0440903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id)');
        $this->addSql('ALTER TABLE dive ADD CONSTRAINT FK_96BB0440D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE dive_type ADD CONSTRAINT FK_E87AD4412E04E766 FOREIGN KEY (dive_id) REFERENCES dive (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dive_type ADD CONSTRAINT FK_E87AD441C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dive DROP FOREIGN KEY FK_96BB0440903E3A94');
        $this->addSql('ALTER TABLE dive DROP FOREIGN KEY FK_96BB0440D60322AC');
        $this->addSql('ALTER TABLE dive_type DROP FOREIGN KEY FK_E87AD4412E04E766');
        $this->addSql('ALTER TABLE dive_type DROP FOREIGN KEY FK_E87AD441C54C8C93');
        $this->addSql('DROP TABLE dive');
        $this->addSql('DROP TABLE dive_type');
        $this->addSql('DROP TABLE environment');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE type');
    }
}
