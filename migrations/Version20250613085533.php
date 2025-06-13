<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250613085533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE duree_consommation (id INT AUTO_INCREMENT NOT NULL, duree VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE temperature (id INT AUTO_INCREMENT NOT NULL, materiel_id INT DEFAULT NULL, valeur VARCHAR(10) NOT NULL, date DATE NOT NULL, INDEX IDX_BE4E2A6C16880AAF (materiel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE tracabilite (id INT AUTO_INCREMENT NOT NULL, duree_id INT DEFAULT NULL, produit VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_7E1E9A8AD13C140 (duree_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE temperature ADD CONSTRAINT FK_BE4E2A6C16880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tracabilite ADD CONSTRAINT FK_7E1E9A8AD13C140 FOREIGN KEY (duree_id) REFERENCES duree_consommation (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE temperature DROP FOREIGN KEY FK_BE4E2A6C16880AAF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tracabilite DROP FOREIGN KEY FK_7E1E9A8AD13C140
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE duree_consommation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE materiel
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE temperature
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE tracabilite
        SQL);
    }
}
