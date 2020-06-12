<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200612092711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE half_journey DROP presences');
        $this->addSql('ALTER TABLE presences ADD half_journey_id INT NOT NULL, ADD time TIME NOT NULL');
        $this->addSql('ALTER TABLE presences ADD CONSTRAINT FK_BDDBEFABC595866A FOREIGN KEY (half_journey_id) REFERENCES half_journey (id)');
        $this->addSql('CREATE INDEX IDX_BDDBEFABC595866A ON presences (half_journey_id)');
        $this->addSql('ALTER TABLE user CHANGE session_id session_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE half_journey ADD presences TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE presences DROP FOREIGN KEY FK_BDDBEFABC595866A');
        $this->addSql('DROP INDEX IDX_BDDBEFABC595866A ON presences');
        $this->addSql('ALTER TABLE presences DROP half_journey_id, DROP time');
        $this->addSql('ALTER TABLE user CHANGE session_id session_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
