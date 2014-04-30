<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140430135004 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE Topic (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Message (id INT AUTO_INCREMENT NOT NULL, topic_id INT NOT NULL, message LONGTEXT DEFAULT NULL, time DATETIME DEFAULT NULL, user VARCHAR(50) DEFAULT NULL, INDEX IDX_790009E31F55203D (topic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE Message ADD CONSTRAINT FK_790009E31F55203D FOREIGN KEY (topic_id) REFERENCES Topic (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Message DROP FOREIGN KEY FK_790009E31F55203D");
        $this->addSql("DROP TABLE Topic");
        $this->addSql("DROP TABLE Message");
    }
}
