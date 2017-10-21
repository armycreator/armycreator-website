<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171020145043 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM oauth_auth_code');
        $this->addSql('DELETE FROM oauth_refresh_token');
        $this->addSql('DELETE FROM oauth_access_token');
        $this->addSql('ALTER TABLE oauth_auth_code DROP FOREIGN KEY FK_4D12F0E0A76ED395;');
        $this->addSql('DROP INDEX IDX_4D12F0E0A76ED395 ON oauth_auth_code;');
        $this->addSql('ALTER TABLE oauth_auth_code CHANGE user_id user_id INT NOT NULL;');
        $this->addSql('ALTER TABLE oauth_refresh_token DROP FOREIGN KEY FK_55DCF755A76ED395;');
        $this->addSql('DROP INDEX IDX_55DCF755A76ED395 ON oauth_refresh_token;');
        $this->addSql('ALTER TABLE oauth_refresh_token CHANGE user_id user_id INT NOT NULL;');
        $this->addSql('ALTER TABLE oauth_access_token DROP FOREIGN KEY FK_F7FA86A4A76ED395;');
        $this->addSql('DROP INDEX IDX_F7FA86A4A76ED395 ON oauth_access_token;');
        $this->addSql('ALTER TABLE oauth_access_token CHANGE user_id user_id INT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
