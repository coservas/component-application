<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200302072727 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE users ADD fname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD sname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD mname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users DROP roles');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users ADD roles TEXT NOT NULL');
        $this->addSql('ALTER TABLE users DROP fname');
        $this->addSql('ALTER TABLE users DROP sname');
        $this->addSql('ALTER TABLE users DROP mname');
        $this->addSql('COMMENT ON COLUMN users.roles IS \'(DC2Type:array)\'');
    }
}
