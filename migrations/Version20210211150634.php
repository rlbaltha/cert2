<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210211150634 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE checklist (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, anchor_id INT DEFAULT NULL, sphere1_id INT DEFAULT NULL, sphere2_id INT DEFAULT NULL, sphere3_id INT DEFAULT NULL, seminar_id INT DEFAULT NULL, capstone_id INT DEFAULT NULL, presentation VARCHAR(255) DEFAULT NULL, athena DATETIME DEFAULT NULL, pre_assess DATETIME DEFAULT NULL, post_assess DATETIME DEFAULT NULL, orientation DATETIME DEFAULT NULL, appliedtograd VARCHAR(255) DEFAULT NULL, INDEX IDX_5C696D2FA76ED395 (user_id), INDEX IDX_5C696D2F75DD7C26 (anchor_id), INDEX IDX_5C696D2F12789A65 (sphere1_id), INDEX IDX_5C696D2FCD358B (sphere2_id), INDEX IDX_5C696D2FB87152EE (sphere3_id), INDEX IDX_5C696D2F735A6AB8 (seminar_id), INDEX IDX_5C696D2F1C97E0B5 (capstone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE checklist ADD CONSTRAINT FK_5C696D2FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE checklist ADD CONSTRAINT FK_5C696D2F75DD7C26 FOREIGN KEY (anchor_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE checklist ADD CONSTRAINT FK_5C696D2F12789A65 FOREIGN KEY (sphere1_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE checklist ADD CONSTRAINT FK_5C696D2FCD358B FOREIGN KEY (sphere2_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE checklist ADD CONSTRAINT FK_5C696D2FB87152EE FOREIGN KEY (sphere3_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE checklist ADD CONSTRAINT FK_5C696D2F735A6AB8 FOREIGN KEY (seminar_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE checklist ADD CONSTRAINT FK_5C696D2F1C97E0B5 FOREIGN KEY (capstone_id) REFERENCES course (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE checklist');
    }
}
