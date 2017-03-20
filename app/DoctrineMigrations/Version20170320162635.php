<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170320162635 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        //

        $this->addSql("INSERT INTO `oauth_client` (`id`, `random_id`, `redirect_uris`, `secret`, `allowed_grant_types`, `name`) VALUES (1, '1fmv6y40q7r440oc48sswwc40sos88ww408088o0c8g8wko40c', 'a:0:{}', '5qquyxdde4g0g8kkwcgso40kk4gcwckg44wgks0484ko8cs0o', 'a:1:{i:0;s:8:\"password\";}', 'devel');");


    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql("DELETE FROM  `oauth_client` WHERE id = 1");
    }
}
