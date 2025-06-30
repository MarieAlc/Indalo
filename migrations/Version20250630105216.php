<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250630105216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE tracabilite ADD produit_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tracabilite ADD CONSTRAINT FK_7E1E9A8AF347EFB FOREIGN KEY (produit_id) REFERENCES produit_tracabilite (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7E1E9A8AF347EFB ON tracabilite (produit_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE tracabilite DROP FOREIGN KEY FK_7E1E9A8AF347EFB
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_7E1E9A8AF347EFB ON tracabilite
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tracabilite DROP produit_id
        SQL);
    }
}
