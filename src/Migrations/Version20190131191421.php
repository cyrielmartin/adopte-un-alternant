<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190131191421 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE visit_card_skill (visit_card_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_2E16BA21C459EE7 (visit_card_id), INDEX IDX_2E16BA25585C142 (skill_id), PRIMARY KEY(visit_card_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE visit_card_skill ADD CONSTRAINT FK_2E16BA21C459EE7 FOREIGN KEY (visit_card_id) REFERENCES visit_card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visit_card_skill ADD CONSTRAINT FK_2E16BA25585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE skill_visit_card');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE skill_visit_card (skill_id INT NOT NULL, visit_card_id INT NOT NULL, INDEX IDX_DCC5B9631C459EE7 (visit_card_id), INDEX IDX_DCC5B9635585C142 (skill_id), PRIMARY KEY(skill_id, visit_card_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE skill_visit_card ADD CONSTRAINT FK_DCC5B9631C459EE7 FOREIGN KEY (visit_card_id) REFERENCES visit_card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_visit_card ADD CONSTRAINT FK_DCC5B9635585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE visit_card_skill');
    }
}
