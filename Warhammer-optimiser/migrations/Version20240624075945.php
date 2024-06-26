<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624075945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sets ADD classe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sets ADD CONSTRAINT FK_948D45D18F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('CREATE INDEX IDX_948D45D18F5EA509 ON sets (classe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sets DROP FOREIGN KEY FK_948D45D18F5EA509');
        $this->addSql('DROP INDEX IDX_948D45D18F5EA509 ON sets');
        $this->addSql('ALTER TABLE sets DROP classe_id');
    }
}
