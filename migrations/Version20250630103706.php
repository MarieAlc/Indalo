<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250630103706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE fabrication (id INT AUTO_INCREMENT NOT NULL, recurrence_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_AE0B6B7A2C414CE8 (recurrence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication ADD CONSTRAINT FK_AE0B6B7A2C414CE8 FOREIGN KEY (recurrence_id) REFERENCES recurrence (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_fabrication ADD fabrication_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_fabrication ADD CONSTRAINT FK_D0132FFE2EFC43FC FOREIGN KEY (fabrication_id) REFERENCES fabrication (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D0132FFE2EFC43FC ON produit_fabrication (fabrication_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_fabrication DROP FOREIGN KEY FK_D0132FFE2EFC43FC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication DROP FOREIGN KEY FK_AE0B6B7A2C414CE8
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE fabrication
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D0132FFE2EFC43FC ON produit_fabrication
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_fabrication DROP fabrication_id
        SQL);
    }
}
