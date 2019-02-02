<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190202132320 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE visit_card_mobility (visit_card_id INT NOT NULL, mobility_id INT NOT NULL, INDEX IDX_6E6CCDE01C459EE7 (visit_card_id), INDEX IDX_6E6CCDE08D92EAA4 (mobility_id), PRIMARY KEY(visit_card_id, mobility_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE visit_card_mobility ADD CONSTRAINT FK_6E6CCDE01C459EE7 FOREIGN KEY (visit_card_id) REFERENCES visit_card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visit_card_mobility ADD CONSTRAINT FK_6E6CCDE08D92EAA4 FOREIGN KEY (mobility_id) REFERENCES mobility (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE mobility_visit_card');
        $this->addSql('ALTER TABLE is_recruiter CHANGE company_name company_name VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mobility_visit_card (mobility_id INT NOT NULL, visit_card_id INT NOT NULL, INDEX IDX_F396FE588D92EAA4 (mobility_id), INDEX IDX_F396FE581C459EE7 (visit_card_id), PRIMARY KEY(mobility_id, visit_card_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mobility_visit_card ADD CONSTRAINT FK_F396FE581C459EE7 FOREIGN KEY (visit_card_id) REFERENCES visit_card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mobility_visit_card ADD CONSTRAINT FK_F396FE588D92EAA4 FOREIGN KEY (mobility_id) REFERENCES mobility (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE visit_card_mobility');
        $this->addSql('ALTER TABLE is_recruiter CHANGE company_name company_name VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
