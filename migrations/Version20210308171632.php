<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210308171632 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD gradyear_id INT DEFAULT NULL, DROP gradyear');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64922C07D8D FOREIGN KEY (gradyear_id) REFERENCES year (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64922C07D8D ON user (gradyear_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64922C07D8D');
        $this->addSql('DROP INDEX IDX_8D93D64922C07D8D ON `user`');
        $this->addSql('ALTER TABLE `user` ADD gradyear VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP gradyear_id');
    }
}
