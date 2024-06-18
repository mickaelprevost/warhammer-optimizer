<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240617095102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE items ADD classe_id INT DEFAULT NULL, ADD sets_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DF40DDE7E FOREIGN KEY (sets_id) REFERENCES sets (id)');
        $this->addSql('CREATE INDEX IDX_E11EE94D8F5EA509 ON items (classe_id)');
        $this->addSql('CREATE INDEX IDX_E11EE94DF40DDE7E ON items (sets_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D8F5EA509');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DF40DDE7E');
        $this->addSql('DROP INDEX IDX_E11EE94D8F5EA509 ON items');
        $this->addSql('DROP INDEX IDX_E11EE94DF40DDE7E ON items');
        $this->addSql('ALTER TABLE items DROP classe_id, DROP sets_id');
    }
}
