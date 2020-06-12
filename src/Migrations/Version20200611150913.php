<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200611150913 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE presences ADD relation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE presences ADD CONSTRAINT FK_BDDBEFAB3256915B FOREIGN KEY (relation_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BDDBEFAB3256915B ON presences (relation_id)');
        $this->addSql('ALTER TABLE user CHANGE session_id session_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE presences DROP FOREIGN KEY FK_BDDBEFAB3256915B');
        $this->addSql('DROP INDEX IDX_BDDBEFAB3256915B ON presences');
        $this->addSql('ALTER TABLE presences DROP relation_id');
        $this->addSql('ALTER TABLE user CHANGE session_id session_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}