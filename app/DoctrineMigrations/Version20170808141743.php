<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170808141743 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $filename = __DIR__  . '/UnitHasUnitGroup.sql';
        $this->addSql(file_get_contents($filename));


        // $handle = fopen($filename, 'r');
        // while (($line = fgets($handle)) !== false) {
        //     // process the line read.
        //     if (!empty(trim($line)) && substr($line, 0, 2) !== '--') {
        //         $line = "SET FOREIGN_KEY_CHECKS=0;" .
        //             $line .
        //             "SET FOREIGN_KEY_CHECKS=1;";
        //         $this->addSql($line);
        //     }
        // }

        // fclose($handle);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $lines[] = "TRUNCATE TABLE UnitHasUnitGroup";

        foreach ($lines as $line) {
            $line = "SET FOREIGN_KEY_CHECKS=0;" .
                $line .
                "SET FOREIGN_KEY_CHECKS=1;";
            $this->addSql($line);
        }
    }
}
