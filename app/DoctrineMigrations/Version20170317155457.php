<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170317155457 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("UPDATE phpbb_config SET config_value = '1' WHERE config_name='tpl_allow_php'");
        $this->addSql("UPDATE phpbb_config SET config_value = 'ArmyCreator Website' WHERE config_name='site_desc'");
        $this->addSql("UPDATE phpbb_config SET config_value = 'ArmyCreator' WHERE config_name='sitename'");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
