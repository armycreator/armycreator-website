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
// $this->addSql('ALTER TABLE oauth_refresh_token DROP FOREIGN KEY FK_55DCF755A76ED395;');
// $this->addSql('DROP INDEX UNIQ_55DCF7555F37A13B ON oauth_refresh_token;');
// $this->addSql('ALTER TABLE oauth_refresh_token DROP token, DROP expires_at, DROP scope;');
// $this->addSql('ALTER TABLE oauth_refresh_token ADD CONSTRAINT FK_55DCF755A76ED395 FOREIGN KEY (user_id) REFERENCES phpbb_users (user_id);');
// $this->addSql('ALTER TABLE oauth_access_token DROP FOREIGN KEY FK_F7FA86A4A76ED395;');
// $this->addSql('DROP INDEX UNIQ_F7FA86A45F37A13B ON oauth_access_token;');
// $this->addSql('ALTER TABLE oauth_access_token DROP token, DROP expires_at, DROP scope;');
$this->addSql('ALTER TABLE oauth_access_token ADD CONSTRAINT FK_F7FA86A4A76ED395 FOREIGN KEY (user_id) REFERENCES phpbb_users (user_id);');
$this->addSql('ALTER TABLE oauth_client DROP random_id, DROP redirect_uris, DROP secret, DROP allowed_grant_types;');
$this->addSql('ALTER TABLE oauth_auth_code DROP FOREIGN KEY FK_4D12F0E0A76ED395;');
$this->addSql('DROP INDEX UNIQ_4D12F0E05F37A13B ON oauth_auth_code;');
$this->addSql('ALTER TABLE oauth_auth_code DROP token, DROP redirect_uri, DROP expires_at, DROP scope;');
$this->addSql('ALTER TABLE oauth_auth_code ADD CONSTRAINT FK_4D12F0E0A76ED395 FOREIGN KEY (user_id) REFERENCES phpbb_users (user_id);');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
