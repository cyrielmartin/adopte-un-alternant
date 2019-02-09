<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190207162110 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, is_recruiter_id INT DEFAULT NULL, is_candidate_id INT DEFAULT NULL, content LONGTEXT NOT NULL, send_at DATETIME NOT NULL, INDEX IDX_B6BD307F35D5019D (is_recruiter_id), INDEX IDX_B6BD307FB103645F (is_candidate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F35D5019D FOREIGN KEY (is_recruiter_id) REFERENCES is_recruiter (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FB103645F FOREIGN KEY (is_candidate_id) REFERENCES is_candidate (id)');
        $this->addSql('ALTER TABLE is_recruiter DROP email_custom');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE message');
        $this->addSql('ALTER TABLE is_recruiter ADD email_custom LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
