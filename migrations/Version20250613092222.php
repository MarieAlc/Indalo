<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250613092222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE nettoyage_effectue (id INT AUTO_INCREMENT NOT NULL, plan_nettoyage_id INT DEFAULT NULL, utilisateur_id INT DEFAULT NULL, date DATE NOT NULL, valide TINYINT(1) NOT NULL, INDEX IDX_C43D02C41E35BE6E (plan_nettoyage_id), INDEX IDX_C43D02C4FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE plan_nettoyage (id INT AUTO_INCREMENT NOT NULL, reccurence_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_81CD60976290D08E (reccurence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE recurrence (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, intervalle_jour INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nettoyage_effectue ADD CONSTRAINT FK_C43D02C41E35BE6E FOREIGN KEY (plan_nettoyage_id) REFERENCES plan_nettoyage (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nettoyage_effectue ADD CONSTRAINT FK_C43D02C4FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plan_nettoyage ADD CONSTRAINT FK_81CD60976290D08E FOREIGN KEY (reccurence_id) REFERENCES recurrence (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE nettoyage_effectue DROP FOREIGN KEY FK_C43D02C41E35BE6E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nettoyage_effectue DROP FOREIGN KEY FK_C43D02C4FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plan_nettoyage DROP FOREIGN KEY FK_81CD60976290D08E
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE nettoyage_effectue
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE plan_nettoyage
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE recurrence
        SQL);
    }
}
