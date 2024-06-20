<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620082850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE itemstype_items DROP FOREIGN KEY FK_DE255BA060C8DDDE');
        $this->addSql('ALTER TABLE itemstype_items DROP FOREIGN KEY FK_DE255BA06BB0AE84');
        $this->addSql('DROP TABLE itemstype_items');
        $this->addSql('ALTER TABLE items ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DC54C8C93 FOREIGN KEY (type_id) REFERENCES itemstype (id)');
        $this->addSql('CREATE INDEX IDX_E11EE94DC54C8C93 ON items (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE itemstype_items (itemstype_id INT NOT NULL, items_id INT NOT NULL, INDEX IDX_DE255BA060C8DDDE (itemstype_id), INDEX IDX_DE255BA06BB0AE84 (items_id), PRIMARY KEY(itemstype_id, items_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE itemstype_items ADD CONSTRAINT FK_DE255BA060C8DDDE FOREIGN KEY (itemstype_id) REFERENCES itemstype (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE itemstype_items ADD CONSTRAINT FK_DE255BA06BB0AE84 FOREIGN KEY (items_id) REFERENCES items (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DC54C8C93');
        $this->addSql('DROP INDEX IDX_E11EE94DC54C8C93 ON items');
        $this->addSql('ALTER TABLE items DROP type_id');
    }
}
