<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220905143700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dive (id INT AUTO_INCREMENT NOT NULL, diving_environment_id INT NOT NULL, diving_role_id INT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date DATETIME NOT NULL, total_time INT NOT NULL, max_depth DOUBLE PRECISION NOT NULL, gas JSON NOT NULL, INDEX IDX_96BB0440705B70FE (diving_environment_id), INDEX IDX_96BB04401D07E1FC (diving_role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dive_diving_type (dive_id INT NOT NULL, diving_type_id INT NOT NULL, INDEX IDX_225A9FA02E04E766 (dive_id), INDEX IDX_225A9FA0E484FC3 (diving_type_id), PRIMARY KEY(dive_id, diving_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diving_environment (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diving_role (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diving_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dive ADD CONSTRAINT FK_96BB0440705B70FE FOREIGN KEY (diving_environment_id) REFERENCES diving_environment (id)');
        $this->addSql('ALTER TABLE dive ADD CONSTRAINT FK_96BB04401D07E1FC FOREIGN KEY (diving_role_id) REFERENCES diving_role (id)');
        $this->addSql('ALTER TABLE dive_diving_type ADD CONSTRAINT FK_225A9FA02E04E766 FOREIGN KEY (dive_id) REFERENCES dive (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dive_diving_type ADD CONSTRAINT FK_225A9FA0E484FC3 FOREIGN KEY (diving_type_id) REFERENCES diving_type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dive DROP FOREIGN KEY FK_96BB0440705B70FE');
        $this->addSql('ALTER TABLE dive DROP FOREIGN KEY FK_96BB04401D07E1FC');
        $this->addSql('ALTER TABLE dive_diving_type DROP FOREIGN KEY FK_225A9FA02E04E766');
        $this->addSql('ALTER TABLE dive_diving_type DROP FOREIGN KEY FK_225A9FA0E484FC3');
        $this->addSql('DROP TABLE dive');
        $this->addSql('DROP TABLE dive_diving_type');
        $this->addSql('DROP TABLE diving_environment');
        $this->addSql('DROP TABLE diving_role');
        $this->addSql('DROP TABLE diving_type');
        $this->addSql('DROP TABLE user');
    }
}
