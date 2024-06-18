<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240618044716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE template_liste (id INT AUTO_INCREMENT NOT NULL, template_id INT DEFAULT NULL, items_id INT DEFAULT NULL, INDEX IDX_CF24F93B5DA0FB8 (template_id), INDEX IDX_CF24F93B6BB0AE84 (items_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE template_liste ADD CONSTRAINT FK_CF24F93B5DA0FB8 FOREIGN KEY (template_id) REFERENCES template (id)');
        $this->addSql('ALTER TABLE template_liste ADD CONSTRAINT FK_CF24F93B6BB0AE84 FOREIGN KEY (items_id) REFERENCES items (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE template_liste DROP FOREIGN KEY FK_CF24F93B5DA0FB8');
        $this->addSql('ALTER TABLE template_liste DROP FOREIGN KEY FK_CF24F93B6BB0AE84');
        $this->addSql('DROP TABLE template_liste');
    }
}
