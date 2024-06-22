<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240621081233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE template_renown_abilities_liste (id INT AUTO_INCREMENT NOT NULL, template_id INT DEFAULT NULL, renownabilities_id INT DEFAULT NULL, INDEX IDX_FCC975465DA0FB8 (template_id), INDEX IDX_FCC975463DE411FE (renownabilities_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE template_renown_abilities_liste ADD CONSTRAINT FK_FCC975465DA0FB8 FOREIGN KEY (template_id) REFERENCES template (id)');
        $this->addSql('ALTER TABLE template_renown_abilities_liste ADD CONSTRAINT FK_FCC975463DE411FE FOREIGN KEY (renownabilities_id) REFERENCES renownabilities (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE template_renown_abilities_liste DROP FOREIGN KEY FK_FCC975465DA0FB8');
        $this->addSql('ALTER TABLE template_renown_abilities_liste DROP FOREIGN KEY FK_FCC975463DE411FE');
        $this->addSql('DROP TABLE template_renown_abilities_liste');
    }
}
