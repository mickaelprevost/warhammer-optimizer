<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240621065146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE template ADD class_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE template ADD CONSTRAINT FK_97601F83EA000B10 FOREIGN KEY (class_id) REFERENCES classe (id)');
        $this->addSql('CREATE INDEX IDX_97601F83EA000B10 ON template (class_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE template DROP FOREIGN KEY FK_97601F83EA000B10');
        $this->addSql('DROP INDEX IDX_97601F83EA000B10 ON template');
        $this->addSql('ALTER TABLE template DROP class_id');
    }
}
