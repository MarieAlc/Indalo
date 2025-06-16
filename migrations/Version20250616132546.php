<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250616132546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE congelation CHANGE date date DATE NOT NULL COMMENT '(DC2Type:date_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nettoyage_effectue ADD utilisateur_id INT NOT NULL, CHANGE date date DATE NOT NULL COMMENT '(DC2Type:date_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nettoyage_effectue ADD CONSTRAINT FK_C43D02C4FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C43D02C4FB88E14F ON nettoyage_effectue (utilisateur_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plan_nettoyage CHANGE date date DATE DEFAULT NULL COMMENT '(DC2Type:date_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE temperature CHANGE date date DATE NOT NULL COMMENT '(DC2Type:date_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tracabilite CHANGE date date DATE NOT NULL COMMENT '(DC2Type:date_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499AB9D5FB
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_8D93D6499AB9D5FB ON user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP nettoyage_effectue_id
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE congelation CHANGE date date DATE NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nettoyage_effectue DROP FOREIGN KEY FK_C43D02C4FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_C43D02C4FB88E14F ON nettoyage_effectue
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nettoyage_effectue DROP utilisateur_id, CHANGE date date DATE NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plan_nettoyage CHANGE date date DATE DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE temperature CHANGE date date DATE NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tracabilite CHANGE date date DATE NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD nettoyage_effectue_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D6499AB9D5FB FOREIGN KEY (nettoyage_effectue_id) REFERENCES nettoyage_effectue (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D6499AB9D5FB ON user (nettoyage_effectue_id)
        SQL);
    }
}
