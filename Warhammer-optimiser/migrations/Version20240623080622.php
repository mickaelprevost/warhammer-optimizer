<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240623080622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE template_talismans_liste ADD template_id INT DEFAULT NULL, ADD talismans_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE template_talismans_liste ADD CONSTRAINT FK_417C3EEE5DA0FB8 FOREIGN KEY (template_id) REFERENCES template (id)');
        $this->addSql('ALTER TABLE template_talismans_liste ADD CONSTRAINT FK_417C3EEE3B465BC8 FOREIGN KEY (talismans_id) REFERENCES talismans (id)');
        $this->addSql('CREATE INDEX IDX_417C3EEE5DA0FB8 ON template_talismans_liste (template_id)');
        $this->addSql('CREATE INDEX IDX_417C3EEE3B465BC8 ON template_talismans_liste (talismans_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE template_talismans_liste DROP FOREIGN KEY FK_417C3EEE5DA0FB8');
        $this->addSql('ALTER TABLE template_talismans_liste DROP FOREIGN KEY FK_417C3EEE3B465BC8');
        $this->addSql('DROP INDEX IDX_417C3EEE5DA0FB8 ON template_talismans_liste');
        $this->addSql('DROP INDEX IDX_417C3EEE3B465BC8 ON template_talismans_liste');
        $this->addSql('ALTER TABLE template_talismans_liste DROP template_id, DROP talismans_id');
    }
}
