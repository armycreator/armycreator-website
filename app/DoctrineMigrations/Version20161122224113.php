<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161122224113 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE SquadLineStuff (id INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, asManyAsUnit TINYINT(1) NOT NULL, unitStuff_id INT DEFAULT NULL, squadLine_id INT DEFAULT NULL, INDEX IDX_321CEB634C7D9AA9 (unitStuff_id), INDEX IDX_321CEB637DEFE82 (squadLine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Stuff (id INT AUTO_INCREMENT NOT NULL, breed_id INT DEFAULT NULL, game_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, defaultPoints DOUBLE PRECISION NOT NULL, auto TINYINT(1) NOT NULL, importedId INT DEFAULT NULL, description LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:object)\', discriminator VARCHAR(255) NOT NULL, INDEX IDX_9880D73AA8B4A30F (breed_id), INDEX IDX_9880D73AE48FD905 (game_id), INDEX import_idx (breed_id, importedId, discriminator), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UserHasUnit (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, unit_id INT DEFAULT NULL, number SMALLINT NOT NULL, INDEX IDX_D062AD98A76ED395 (user_id), INDEX IDX_D062AD98F8BD700D (unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UserPreference (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, breed_id INT DEFAULT NULL, showDefaultStuff TINYINT(1) NOT NULL, showStuffDescription TINYINT(1) NOT NULL, showUnitPoints TINYINT(1) NOT NULL, showStuffPoints TINYINT(1) NOT NULL, separator_ VARCHAR(10) NOT NULL, colorSquadType VARCHAR(20) NOT NULL, colorSquad VARCHAR(20) NOT NULL, colorSquadDetail VARCHAR(20) NOT NULL, showNbIfAlone TINYINT(1) NOT NULL, showUnitCarac TINYINT(1) NOT NULL, showPersonnalName TINYINT(1) NOT NULL, showUnitFeature TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_922CE7A2A76ED395 (user_id), INDEX IDX_922CE7A2A8B4A30F (breed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UnitStuff (id INT AUTO_INCREMENT NOT NULL, unit_id INT DEFAULT NULL, stuff_id INT DEFAULT NULL, points DOUBLE PRECISION NOT NULL, auto TINYINT(1) NOT NULL, visible TINYINT(1) NOT NULL, INDEX IDX_CB92C4D8F8BD700D (unit_id), INDEX IDX_CB92C4D8950A1740 (stuff_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Donation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, createdAt DATETIME NOT NULL, year INT NOT NULL, email VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, isPublic TINYINT(1) NOT NULL, INDEX IDX_C893E3F6A76ED395 (user_id), INDEX year (year), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UnitType (id INT AUTO_INCREMENT NOT NULL, breed_id INT DEFAULT NULL, importedId INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, position INT NOT NULL, color VARCHAR(10) DEFAULT NULL, INDEX IDX_8D6C2AE5A8B4A30F (breed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Game (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(32) NOT NULL, name VARCHAR(255) NOT NULL, unitFeaturePublic TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_83199EB277153098 (code), UNIQUE INDEX UNIQ_83199EB25E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE BreedGroup (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_1F5348B5E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Squad (id INT AUTO_INCREMENT NOT NULL, army_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, position INT NOT NULL, createDate DATETIME DEFAULT NULL, updateDate DATETIME DEFAULT NULL, unitType_id INT DEFAULT NULL, unitGroup_id INT DEFAULT NULL, INDEX IDX_E11D0E318D2742D (army_id), INDEX IDX_E11D0E3649BB97A (unitType_id), INDEX IDX_E11D0E3272354AE (unitGroup_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Breed (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, available TINYINT(1) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, newVersion_id INT DEFAULT NULL, breedGroup_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_396EA74B5E237E06 (name), UNIQUE INDEX UNIQ_396EA74B989D9B62 (slug), UNIQUE INDEX UNIQ_396EA74B7BE280A7 (newVersion_id), INDEX IDX_396EA74BE48FD905 (game_id), INDEX IDX_396EA74BDC687762 (breedGroup_id), INDEX available (available), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UserUnitFeature (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, unit_id INT DEFAULT NULL, feature LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:object)\', INDEX IDX_7475C752A76ED395 (user_id), INDEX IDX_7475C752F8BD700D (unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE SquadLine (id INT AUTO_INCREMENT NOT NULL, unit_id INT DEFAULT NULL, squad_id INT DEFAULT NULL, number INT NOT NULL, position INT NOT NULL, inactive TINYINT(1) NOT NULL, createDate DATETIME DEFAULT NULL, updateDate DATETIME DEFAULT NULL, INDEX IDX_8C04CE39F8BD700D (unit_id), INDEX IDX_8C04CE39DF1B2C7C (squad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE AbstractUnit (id INT AUTO_INCREMENT NOT NULL, breed_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, points INT NOT NULL, importedId INT DEFAULT NULL, importedType VARCHAR(255) DEFAULT NULL, unitType_id INT DEFAULT NULL, discriminator VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_74D1287D989D9B62 (slug), INDEX IDX_74D1287DA8B4A30F (breed_id), INDEX IDX_74D1287D649BB97A (unitType_id), INDEX import_idx (importedId, discriminator), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Unit (id INT NOT NULL, parent_id INT DEFAULT NULL, canModifyNumber TINYINT(1) NOT NULL, feature LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:object)\', INDEX IDX_7C89A36D727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ArmyGroup (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_6DFA78F7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, slug VARCHAR(255) NOT NULL, forumId INT NOT NULL, wantToPlay TINYINT(1) DEFAULT NULL, informations LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json_array)\', avatar VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D5428AED92FC23A8 (username_canonical), UNIQUE INDEX UNIQ_D5428AEDA0D96FBF (email_canonical), INDEX forum_id_idx (forumId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE CollectionBreed (user_id INT NOT NULL, breed_id INT NOT NULL, INDEX IDX_A6F9C520A76ED395 (user_id), INDEX IDX_A6F9C520A8B4A30F (breed_id), PRIMARY KEY(user_id, breed_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Army (id INT AUTO_INCREMENT NOT NULL, breed_id INT DEFAULT NULL, user_id INT DEFAULT NULL, status VARCHAR(10) NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, currentSlug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, wantedPoints INT NOT NULL, points INT NOT NULL, active_points INT NOT NULL, isShared TINYINT(1) NOT NULL, createDate DATETIME DEFAULT NULL, updateDate DATETIME DEFAULT NULL, armyGroup_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_AC138008989D9B62 (slug), INDEX IDX_AC138008A8B4A30F (breed_id), INDEX IDX_AC1380087475930C (armyGroup_id), INDEX IDX_AC138008A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UnitHasUnitGroup (id INT AUTO_INCREMENT NOT NULL, unit_id INT DEFAULT NULL, group_id INT DEFAULT NULL, unitNumber INT NOT NULL, importedId INT DEFAULT NULL, mainUnit TINYINT(1) NOT NULL, canChooseNumber TINYINT(1) NOT NULL, position INT DEFAULT NULL, INDEX IDX_A61BF2AF8BD700D (unit_id), INDEX IDX_A61BF2AFE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UnitGroup (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth_client (id INT AUTO_INCREMENT NOT NULL, random_id VARCHAR(255) NOT NULL, redirect_uris LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', secret VARCHAR(255) NOT NULL, allowed_grant_types LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth_access_token (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_F7FA86A45F37A13B (token), INDEX IDX_F7FA86A419EB6921 (client_id), INDEX IDX_F7FA86A4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth_auth_code (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, redirect_uri LONGTEXT NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_4D12F0E05F37A13B (token), INDEX IDX_4D12F0E019EB6921 (client_id), INDEX IDX_4D12F0E0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth_refresh_token (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_55DCF7555F37A13B (token), INDEX IDX_55DCF75519EB6921 (client_id), INDEX IDX_55DCF755A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE SquadLineStuff ADD CONSTRAINT FK_321CEB634C7D9AA9 FOREIGN KEY (unitStuff_id) REFERENCES UnitStuff (id)');
        $this->addSql('ALTER TABLE SquadLineStuff ADD CONSTRAINT FK_321CEB637DEFE82 FOREIGN KEY (squadLine_id) REFERENCES SquadLine (id)');
        $this->addSql('ALTER TABLE Stuff ADD CONSTRAINT FK_9880D73AA8B4A30F FOREIGN KEY (breed_id) REFERENCES Breed (id)');
        $this->addSql('ALTER TABLE Stuff ADD CONSTRAINT FK_9880D73AE48FD905 FOREIGN KEY (game_id) REFERENCES Game (id)');
        $this->addSql('ALTER TABLE UserHasUnit ADD CONSTRAINT FK_D062AD98A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE UserHasUnit ADD CONSTRAINT FK_D062AD98F8BD700D FOREIGN KEY (unit_id) REFERENCES Unit (id)');
        $this->addSql('ALTER TABLE UserPreference ADD CONSTRAINT FK_922CE7A2A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE UserPreference ADD CONSTRAINT FK_922CE7A2A8B4A30F FOREIGN KEY (breed_id) REFERENCES Breed (id)');
        $this->addSql('ALTER TABLE UnitStuff ADD CONSTRAINT FK_CB92C4D8F8BD700D FOREIGN KEY (unit_id) REFERENCES Unit (id)');
        $this->addSql('ALTER TABLE UnitStuff ADD CONSTRAINT FK_CB92C4D8950A1740 FOREIGN KEY (stuff_id) REFERENCES Stuff (id)');
        $this->addSql('ALTER TABLE Donation ADD CONSTRAINT FK_C893E3F6A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE UnitType ADD CONSTRAINT FK_8D6C2AE5A8B4A30F FOREIGN KEY (breed_id) REFERENCES Breed (id)');
        $this->addSql('ALTER TABLE BreedGroup ADD CONSTRAINT FK_1F5348B5E48FD905 FOREIGN KEY (game_id) REFERENCES Game (id)');
        $this->addSql('ALTER TABLE Squad ADD CONSTRAINT FK_E11D0E318D2742D FOREIGN KEY (army_id) REFERENCES Army (id)');
        $this->addSql('ALTER TABLE Squad ADD CONSTRAINT FK_E11D0E3649BB97A FOREIGN KEY (unitType_id) REFERENCES UnitType (id)');
        $this->addSql('ALTER TABLE Squad ADD CONSTRAINT FK_E11D0E3272354AE FOREIGN KEY (unitGroup_id) REFERENCES UnitGroup (id)');
        $this->addSql('ALTER TABLE Breed ADD CONSTRAINT FK_396EA74B7BE280A7 FOREIGN KEY (newVersion_id) REFERENCES Breed (id)');
        $this->addSql('ALTER TABLE Breed ADD CONSTRAINT FK_396EA74BE48FD905 FOREIGN KEY (game_id) REFERENCES Game (id)');
        $this->addSql('ALTER TABLE Breed ADD CONSTRAINT FK_396EA74BDC687762 FOREIGN KEY (breedGroup_id) REFERENCES BreedGroup (id)');
        $this->addSql('ALTER TABLE UserUnitFeature ADD CONSTRAINT FK_7475C752A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE UserUnitFeature ADD CONSTRAINT FK_7475C752F8BD700D FOREIGN KEY (unit_id) REFERENCES Unit (id)');
        $this->addSql('ALTER TABLE SquadLine ADD CONSTRAINT FK_8C04CE39F8BD700D FOREIGN KEY (unit_id) REFERENCES Unit (id)');
        $this->addSql('ALTER TABLE SquadLine ADD CONSTRAINT FK_8C04CE39DF1B2C7C FOREIGN KEY (squad_id) REFERENCES Squad (id)');
        $this->addSql('ALTER TABLE AbstractUnit ADD CONSTRAINT FK_74D1287DA8B4A30F FOREIGN KEY (breed_id) REFERENCES Breed (id)');
        $this->addSql('ALTER TABLE AbstractUnit ADD CONSTRAINT FK_74D1287D649BB97A FOREIGN KEY (unitType_id) REFERENCES UnitType (id)');
        $this->addSql('ALTER TABLE Unit ADD CONSTRAINT FK_7C89A36D727ACA70 FOREIGN KEY (parent_id) REFERENCES Unit (id)');
        $this->addSql('ALTER TABLE Unit ADD CONSTRAINT FK_7C89A36DBF396750 FOREIGN KEY (id) REFERENCES AbstractUnit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ArmyGroup ADD CONSTRAINT FK_6DFA78F7A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE CollectionBreed ADD CONSTRAINT FK_A6F9C520A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE CollectionBreed ADD CONSTRAINT FK_A6F9C520A8B4A30F FOREIGN KEY (breed_id) REFERENCES Breed (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Army ADD CONSTRAINT FK_AC138008A8B4A30F FOREIGN KEY (breed_id) REFERENCES Breed (id)');
        $this->addSql('ALTER TABLE Army ADD CONSTRAINT FK_AC1380087475930C FOREIGN KEY (armyGroup_id) REFERENCES ArmyGroup (id)');
        $this->addSql('ALTER TABLE Army ADD CONSTRAINT FK_AC138008A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE UnitHasUnitGroup ADD CONSTRAINT FK_A61BF2AF8BD700D FOREIGN KEY (unit_id) REFERENCES Unit (id)');
        $this->addSql('ALTER TABLE UnitHasUnitGroup ADD CONSTRAINT FK_A61BF2AFE54D947 FOREIGN KEY (group_id) REFERENCES UnitGroup (id)');
        $this->addSql('ALTER TABLE UnitGroup ADD CONSTRAINT FK_FF137823BF396750 FOREIGN KEY (id) REFERENCES AbstractUnit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oauth_access_token ADD CONSTRAINT FK_F7FA86A419EB6921 FOREIGN KEY (client_id) REFERENCES oauth_client (id)');
        $this->addSql('ALTER TABLE oauth_access_token ADD CONSTRAINT FK_F7FA86A4A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE oauth_auth_code ADD CONSTRAINT FK_4D12F0E019EB6921 FOREIGN KEY (client_id) REFERENCES oauth_client (id)');
        $this->addSql('ALTER TABLE oauth_auth_code ADD CONSTRAINT FK_4D12F0E0A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE oauth_refresh_token ADD CONSTRAINT FK_55DCF75519EB6921 FOREIGN KEY (client_id) REFERENCES oauth_client (id)');
        $this->addSql('ALTER TABLE oauth_refresh_token ADD CONSTRAINT FK_55DCF755A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE UnitStuff DROP FOREIGN KEY FK_CB92C4D8950A1740');
        $this->addSql('ALTER TABLE SquadLineStuff DROP FOREIGN KEY FK_321CEB634C7D9AA9');
        $this->addSql('ALTER TABLE Squad DROP FOREIGN KEY FK_E11D0E3649BB97A');
        $this->addSql('ALTER TABLE AbstractUnit DROP FOREIGN KEY FK_74D1287D649BB97A');
        $this->addSql('ALTER TABLE Stuff DROP FOREIGN KEY FK_9880D73AE48FD905');
        $this->addSql('ALTER TABLE BreedGroup DROP FOREIGN KEY FK_1F5348B5E48FD905');
        $this->addSql('ALTER TABLE Breed DROP FOREIGN KEY FK_396EA74BE48FD905');
        $this->addSql('ALTER TABLE Breed DROP FOREIGN KEY FK_396EA74BDC687762');
        $this->addSql('ALTER TABLE SquadLine DROP FOREIGN KEY FK_8C04CE39DF1B2C7C');
        $this->addSql('ALTER TABLE Stuff DROP FOREIGN KEY FK_9880D73AA8B4A30F');
        $this->addSql('ALTER TABLE UserPreference DROP FOREIGN KEY FK_922CE7A2A8B4A30F');
        $this->addSql('ALTER TABLE UnitType DROP FOREIGN KEY FK_8D6C2AE5A8B4A30F');
        $this->addSql('ALTER TABLE Breed DROP FOREIGN KEY FK_396EA74B7BE280A7');
        $this->addSql('ALTER TABLE AbstractUnit DROP FOREIGN KEY FK_74D1287DA8B4A30F');
        $this->addSql('ALTER TABLE CollectionBreed DROP FOREIGN KEY FK_A6F9C520A8B4A30F');
        $this->addSql('ALTER TABLE Army DROP FOREIGN KEY FK_AC138008A8B4A30F');
        $this->addSql('ALTER TABLE SquadLineStuff DROP FOREIGN KEY FK_321CEB637DEFE82');
        $this->addSql('ALTER TABLE Unit DROP FOREIGN KEY FK_7C89A36DBF396750');
        $this->addSql('ALTER TABLE UnitGroup DROP FOREIGN KEY FK_FF137823BF396750');
        $this->addSql('ALTER TABLE UserHasUnit DROP FOREIGN KEY FK_D062AD98F8BD700D');
        $this->addSql('ALTER TABLE UnitStuff DROP FOREIGN KEY FK_CB92C4D8F8BD700D');
        $this->addSql('ALTER TABLE UserUnitFeature DROP FOREIGN KEY FK_7475C752F8BD700D');
        $this->addSql('ALTER TABLE SquadLine DROP FOREIGN KEY FK_8C04CE39F8BD700D');
        $this->addSql('ALTER TABLE Unit DROP FOREIGN KEY FK_7C89A36D727ACA70');
        $this->addSql('ALTER TABLE UnitHasUnitGroup DROP FOREIGN KEY FK_A61BF2AF8BD700D');
        $this->addSql('ALTER TABLE Army DROP FOREIGN KEY FK_AC1380087475930C');
        $this->addSql('ALTER TABLE UserHasUnit DROP FOREIGN KEY FK_D062AD98A76ED395');
        $this->addSql('ALTER TABLE UserPreference DROP FOREIGN KEY FK_922CE7A2A76ED395');
        $this->addSql('ALTER TABLE Donation DROP FOREIGN KEY FK_C893E3F6A76ED395');
        $this->addSql('ALTER TABLE UserUnitFeature DROP FOREIGN KEY FK_7475C752A76ED395');
        $this->addSql('ALTER TABLE ArmyGroup DROP FOREIGN KEY FK_6DFA78F7A76ED395');
        $this->addSql('ALTER TABLE CollectionBreed DROP FOREIGN KEY FK_A6F9C520A76ED395');
        $this->addSql('ALTER TABLE Army DROP FOREIGN KEY FK_AC138008A76ED395');
        $this->addSql('ALTER TABLE oauth_access_token DROP FOREIGN KEY FK_F7FA86A4A76ED395');
        $this->addSql('ALTER TABLE oauth_auth_code DROP FOREIGN KEY FK_4D12F0E0A76ED395');
        $this->addSql('ALTER TABLE oauth_refresh_token DROP FOREIGN KEY FK_55DCF755A76ED395');
        $this->addSql('ALTER TABLE Squad DROP FOREIGN KEY FK_E11D0E318D2742D');
        $this->addSql('ALTER TABLE Squad DROP FOREIGN KEY FK_E11D0E3272354AE');
        $this->addSql('ALTER TABLE UnitHasUnitGroup DROP FOREIGN KEY FK_A61BF2AFE54D947');
        $this->addSql('ALTER TABLE oauth_access_token DROP FOREIGN KEY FK_F7FA86A419EB6921');
        $this->addSql('ALTER TABLE oauth_auth_code DROP FOREIGN KEY FK_4D12F0E019EB6921');
        $this->addSql('ALTER TABLE oauth_refresh_token DROP FOREIGN KEY FK_55DCF75519EB6921');
        $this->addSql('DROP TABLE SquadLineStuff');
        $this->addSql('DROP TABLE Stuff');
        $this->addSql('DROP TABLE UserHasUnit');
        $this->addSql('DROP TABLE UserPreference');
        $this->addSql('DROP TABLE UnitStuff');
        $this->addSql('DROP TABLE Donation');
        $this->addSql('DROP TABLE UnitType');
        $this->addSql('DROP TABLE Game');
        $this->addSql('DROP TABLE BreedGroup');
        $this->addSql('DROP TABLE Squad');
        $this->addSql('DROP TABLE Breed');
        $this->addSql('DROP TABLE UserUnitFeature');
        $this->addSql('DROP TABLE SquadLine');
        $this->addSql('DROP TABLE AbstractUnit');
        $this->addSql('DROP TABLE Unit');
        $this->addSql('DROP TABLE ArmyGroup');
        $this->addSql('DROP TABLE Users');
        $this->addSql('DROP TABLE CollectionBreed');
        $this->addSql('DROP TABLE Army');
        $this->addSql('DROP TABLE UnitHasUnitGroup');
        $this->addSql('DROP TABLE UnitGroup');
        $this->addSql('DROP TABLE oauth_client');
        $this->addSql('DROP TABLE oauth_access_token');
        $this->addSql('DROP TABLE oauth_auth_code');
        $this->addSql('DROP TABLE oauth_refresh_token');
    }
}
