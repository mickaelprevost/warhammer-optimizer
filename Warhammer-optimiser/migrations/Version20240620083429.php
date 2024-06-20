<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620083429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE items_items_type (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, type_id INT DEFAULT NULL, INDEX IDX_152AC798126F525E (item_id), INDEX IDX_152AC798C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE items_items_type ADD CONSTRAINT FK_152AC798126F525E FOREIGN KEY (item_id) REFERENCES items (id)');
        $this->addSql('ALTER TABLE items_items_type ADD CONSTRAINT FK_152AC798C54C8C93 FOREIGN KEY (type_id) REFERENCES itemstype (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE items_items_type DROP FOREIGN KEY FK_152AC798126F525E');
        $this->addSql('ALTER TABLE items_items_type DROP FOREIGN KEY FK_152AC798C54C8C93');
        $this->addSql('DROP TABLE items_items_type');
    }
}
