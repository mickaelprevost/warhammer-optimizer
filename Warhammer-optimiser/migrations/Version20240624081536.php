<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624081536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE setbonuses (id INT AUTO_INCREMENT NOT NULL, sets_id INT DEFAULT NULL, INDEX IDX_D8431DC0F40DDE7E (sets_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE setbonuses ADD CONSTRAINT FK_D8431DC0F40DDE7E FOREIGN KEY (sets_id) REFERENCES sets (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE setbonuses DROP FOREIGN KEY FK_D8431DC0F40DDE7E');
        $this->addSql('DROP TABLE setbonuses');
    }
}
