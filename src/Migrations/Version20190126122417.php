<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190126122417 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mobility ADD department_id INT DEFAULT NULL, DROP department_code');
        $this->addSql('ALTER TABLE mobility ADD CONSTRAINT FK_D650201CAE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('CREATE INDEX IDX_D650201CAE80F5DF ON mobility (department_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mobility DROP FOREIGN KEY FK_D650201CAE80F5DF');
        $this->addSql('DROP INDEX IDX_D650201CAE80F5DF ON mobility');
        $this->addSql('ALTER TABLE mobility ADD department_code VARCHAR(5) NOT NULL COLLATE utf8mb4_unicode_ci, DROP department_id');
    }
}
