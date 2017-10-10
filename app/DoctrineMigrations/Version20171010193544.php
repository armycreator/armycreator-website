<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171010193544 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_D5428AED92FC23A8 ON Users');
        $this->addSql('DROP INDEX UNIQ_D5428AEDA0D96FBF ON Users');
        $this->addSql('DROP INDEX UNIQ_D5428AEDC05FB297 ON Users');
        $this->addSql('ALTER TABLE Users DROP username_canonical, DROP email_canonical, DROP enabled, DROP salt, DROP password, DROP confirmation_token, DROP password_requested_at, DROP avatar');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5428AEDF85E0677 ON Users (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5428AEDE7927C74 ON Users (email)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_D5428AEDF85E0677 ON Users');
        $this->addSql('DROP INDEX UNIQ_D5428AEDE7927C74 ON Users');
        $this->addSql('ALTER TABLE Users ADD username_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, ADD email_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, ADD enabled TINYINT(1) NOT NULL, ADD salt VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD confirmation_token VARCHAR(180) DEFAULT NULL COLLATE utf8_unicode_ci, ADD password_requested_at DATETIME DEFAULT NULL, ADD avatar VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5428AED92FC23A8 ON Users (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5428AEDA0D96FBF ON Users (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5428AEDC05FB297 ON Users (confirmation_token)');
    }
}
