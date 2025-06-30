<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250630104053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication DROP FOREIGN KEY FK_AE0B6B7A2C414CE8
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_AE0B6B7A2C414CE8 ON fabrication
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication CHANGE recurrence_id duree_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication ADD CONSTRAINT FK_AE0B6B7AD13C140 FOREIGN KEY (duree_id) REFERENCES duree_consommation (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_AE0B6B7AD13C140 ON fabrication (duree_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication DROP FOREIGN KEY FK_AE0B6B7AD13C140
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_AE0B6B7AD13C140 ON fabrication
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication CHANGE duree_id recurrence_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication ADD CONSTRAINT FK_AE0B6B7A2C414CE8 FOREIGN KEY (recurrence_id) REFERENCES recurrence (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_AE0B6B7A2C414CE8 ON fabrication (recurrence_id)
        SQL);
    }
}
