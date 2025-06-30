<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250630104618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication DROP FOREIGN KEY FK_AE0B6B7AD13C140
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_AE0B6B7AD13C140 ON fabrication
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication ADD duree_consomation_id INT DEFAULT NULL, CHANGE duree_id produit_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication ADD CONSTRAINT FK_AE0B6B7AF347EFB FOREIGN KEY (produit_id) REFERENCES produit_fabrication (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication ADD CONSTRAINT FK_AE0B6B7A7ADCFE40 FOREIGN KEY (duree_consomation_id) REFERENCES duree_consommation (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_AE0B6B7AF347EFB ON fabrication (produit_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_AE0B6B7A7ADCFE40 ON fabrication (duree_consomation_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_fabrication DROP FOREIGN KEY FK_D0132FFE2EFC43FC
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D0132FFE2EFC43FC ON produit_fabrication
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_fabrication DROP fabrication_id
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication DROP FOREIGN KEY FK_AE0B6B7AF347EFB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication DROP FOREIGN KEY FK_AE0B6B7A7ADCFE40
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_AE0B6B7AF347EFB ON fabrication
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_AE0B6B7A7ADCFE40 ON fabrication
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication ADD duree_id INT DEFAULT NULL, DROP produit_id, DROP duree_consomation_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fabrication ADD CONSTRAINT FK_AE0B6B7AD13C140 FOREIGN KEY (duree_id) REFERENCES duree_consommation (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_AE0B6B7AD13C140 ON fabrication (duree_id)
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
}
