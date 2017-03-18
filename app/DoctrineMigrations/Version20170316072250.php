<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170316072250 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO `Users` (`username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `slug`, `forumId`, `wantToPlay`, `informations`, `avatar`) VALUES ('Admin', 'admin', 'admin@yourdomain.com', 'admin@yourdomain.com', 1, '4q5j8u6iau80cogsoc4wcocsksg0k84', '$2y$15$4q5j8u6iau80cogsoc4wce4RiyZI6RVYngHdC23XJ8N6FGnSh2Vwu', '1970-01-01 01:00:00', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', 0, NULL, 'admin', 2, NULL, NULL, '')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DELETE FROM `Users` WHERE `username_canonical` = 'admin'");

    }
}
