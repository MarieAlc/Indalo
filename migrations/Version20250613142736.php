<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250613142736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD nettoyage_effectue_id INT DEFAULT NULL, CHANGE qualification qualification VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D6499AB9D5FB FOREIGN KEY (nettoyage_effectue_id) REFERENCES nettoyage_effectue (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D6499AB9D5FB ON user (nettoyage_effectue_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499AB9D5FB
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_8D93D6499AB9D5FB ON user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP nettoyage_effectue_id, CHANGE qualification qualification VARCHAR(255) NOT NULL
        SQL);
    }
}
