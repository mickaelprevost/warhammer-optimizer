<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240621063002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE basestats (id INT AUTO_INCREMENT NOT NULL, class_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, strenght INT NOT NULL, ballisticskill INT NOT NULL, intel INT NOT NULL, toughness INT NOT NULL, weaponskill INT NOT NULL, initiative INT NOT NULL, willpower INT NOT NULL, wound INT NOT NULL, armor INT DEFAULT NULL, resist INT DEFAULT NULL, block INT DEFAULT NULL, parry INT DEFAULT NULL, dodge INT DEFAULT NULL, disrupt INT DEFAULT NULL, UNIQUE INDEX UNIQ_9C01D9419993BF61 (class_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE basestats ADD CONSTRAINT FK_9C01D9419993BF61 FOREIGN KEY (class_id_id) REFERENCES classe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basestats DROP FOREIGN KEY FK_9C01D9419993BF61');
        $this->addSql('DROP TABLE basestats');
    }
}
