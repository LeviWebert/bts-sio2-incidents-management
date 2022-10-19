<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221019130051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE incident_type (incident_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_66D2209659E53FB9 (incident_id), INDEX IDX_66D22096C54C8C93 (type_id), PRIMARY KEY(incident_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, priority INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, normalized VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incident_type ADD CONSTRAINT FK_66D2209659E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident_type ADD CONSTRAINT FK_66D22096C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident ADD level_id INT NOT NULL, ADD status_id INT NOT NULL');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_3D03A11A5FB14BA7 ON incident (level_id)');
        $this->addSql('CREATE INDEX IDX_3D03A11A6BF700BD ON incident (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A5FB14BA7');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A6BF700BD');
        $this->addSql('ALTER TABLE incident_type DROP FOREIGN KEY FK_66D2209659E53FB9');
        $this->addSql('ALTER TABLE incident_type DROP FOREIGN KEY FK_66D22096C54C8C93');
        $this->addSql('DROP TABLE incident_type');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP INDEX IDX_3D03A11A5FB14BA7 ON incident');
        $this->addSql('DROP INDEX IDX_3D03A11A6BF700BD ON incident');
        $this->addSql('ALTER TABLE incident DROP level_id, DROP status_id');
    }
}
