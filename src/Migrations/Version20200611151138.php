<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200611151138 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE half_journey ADD relation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE half_journey ADD CONSTRAINT FK_F90F71073256915B FOREIGN KEY (relation_id) REFERENCES presences (id)');
        $this->addSql('CREATE INDEX IDX_F90F71073256915B ON half_journey (relation_id)');
        $this->addSql('ALTER TABLE presences CHANGE relation_id relation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE session_id session_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE half_journey DROP FOREIGN KEY FK_F90F71073256915B');
        $this->addSql('DROP INDEX IDX_F90F71073256915B ON half_journey');
        $this->addSql('ALTER TABLE half_journey DROP relation_id');
        $this->addSql('ALTER TABLE presences CHANGE relation_id relation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE session_id session_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
