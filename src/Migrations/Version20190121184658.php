<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190121184658 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE is_candidate_is_recruiter (is_candidate_id INT NOT NULL, is_recruiter_id INT NOT NULL, INDEX IDX_55CA0D17B103645F (is_candidate_id), INDEX IDX_55CA0D1735D5019D (is_recruiter_id), PRIMARY KEY(is_candidate_id, is_recruiter_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_visit_card (skill_id INT NOT NULL, visit_card_id INT NOT NULL, INDEX IDX_DCC5B9635585C142 (skill_id), INDEX IDX_DCC5B9631C459EE7 (visit_card_id), PRIMARY KEY(skill_id, visit_card_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mobility_visit_card (mobility_id INT NOT NULL, visit_card_id INT NOT NULL, INDEX IDX_F396FE588D92EAA4 (mobility_id), INDEX IDX_F396FE581C459EE7 (visit_card_id), PRIMARY KEY(mobility_id, visit_card_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE is_candidate_is_recruiter ADD CONSTRAINT FK_55CA0D17B103645F FOREIGN KEY (is_candidate_id) REFERENCES is_candidate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE is_candidate_is_recruiter ADD CONSTRAINT FK_55CA0D1735D5019D FOREIGN KEY (is_recruiter_id) REFERENCES is_recruiter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_visit_card ADD CONSTRAINT FK_DCC5B9635585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_visit_card ADD CONSTRAINT FK_DCC5B9631C459EE7 FOREIGN KEY (visit_card_id) REFERENCES visit_card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mobility_visit_card ADD CONSTRAINT FK_F396FE588D92EAA4 FOREIGN KEY (mobility_id) REFERENCES mobility (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mobility_visit_card ADD CONSTRAINT FK_F396FE581C459EE7 FOREIGN KEY (visit_card_id) REFERENCES visit_card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visit_card ADD is_candidate_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE visit_card ADD CONSTRAINT FK_C94C6511B103645F FOREIGN KEY (is_candidate_id) REFERENCES is_candidate (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C94C6511B103645F ON visit_card (is_candidate_id)');
        $this->addSql('ALTER TABLE experience ADD visit_card_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C1031C459EE7 FOREIGN KEY (visit_card_id) REFERENCES visit_card (id)');
        $this->addSql('CREATE INDEX IDX_590C1031C459EE7 ON experience (visit_card_id)');
        $this->addSql('ALTER TABLE is_recruiter ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE is_recruiter ADD CONSTRAINT FK_D97E5EB7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D97E5EB7A76ED395 ON is_recruiter (user_id)');
        $this->addSql('ALTER TABLE article ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66A76ED395 ON article (user_id)');
        $this->addSql('ALTER TABLE is_candidate ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE is_candidate ADD CONSTRAINT FK_CF4AE32BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF4AE32BA76ED395 ON is_candidate (user_id)');
        $this->addSql('ALTER TABLE is_story ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE is_story ADD CONSTRAINT FK_A7AAE7487294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A7AAE7487294869C ON is_story (article_id)');
        $this->addSql('ALTER TABLE website ADD visit_card_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE website ADD CONSTRAINT FK_476F5DE71C459EE7 FOREIGN KEY (visit_card_id) REFERENCES visit_card (id)');
        $this->addSql('CREATE INDEX IDX_476F5DE71C459EE7 ON website (visit_card_id)');
        $this->addSql('ALTER TABLE user ADD role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON user (role_id)');
        $this->addSql('ALTER TABLE formation ADD visit_card_id INT DEFAULT NULL, ADD award_level_id INT DEFAULT NULL, ADD school_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF1C459EE7 FOREIGN KEY (visit_card_id) REFERENCES visit_card (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF5D231872 FOREIGN KEY (award_level_id) REFERENCES award_level (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BFC32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('CREATE INDEX IDX_404021BF1C459EE7 ON formation (visit_card_id)');
        $this->addSql('CREATE INDEX IDX_404021BF5D231872 ON formation (award_level_id)');
        $this->addSql('CREATE INDEX IDX_404021BFC32A47EE ON formation (school_id)');
        $this->addSql('ALTER TABLE is_apprenticeship ADD formation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE is_apprenticeship ADD CONSTRAINT FK_4FBCC8985200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBCC8985200282E ON is_apprenticeship (formation_id)');
        $this->addSql('ALTER TABLE additional ADD visit_card_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE additional ADD CONSTRAINT FK_8BD05CE61C459EE7 FOREIGN KEY (visit_card_id) REFERENCES visit_card (id)');
        $this->addSql('CREATE INDEX IDX_8BD05CE61C459EE7 ON additional (visit_card_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE is_candidate_is_recruiter');
        $this->addSql('DROP TABLE skill_visit_card');
        $this->addSql('DROP TABLE mobility_visit_card');
        $this->addSql('ALTER TABLE additional DROP FOREIGN KEY FK_8BD05CE61C459EE7');
        $this->addSql('DROP INDEX IDX_8BD05CE61C459EE7 ON additional');
        $this->addSql('ALTER TABLE additional DROP visit_card_id');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('DROP INDEX IDX_23A0E66A76ED395 ON article');
        $this->addSql('ALTER TABLE article DROP user_id');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C1031C459EE7');
        $this->addSql('DROP INDEX IDX_590C1031C459EE7 ON experience');
        $this->addSql('ALTER TABLE experience DROP visit_card_id');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF1C459EE7');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF5D231872');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BFC32A47EE');
        $this->addSql('DROP INDEX IDX_404021BF1C459EE7 ON formation');
        $this->addSql('DROP INDEX IDX_404021BF5D231872 ON formation');
        $this->addSql('DROP INDEX IDX_404021BFC32A47EE ON formation');
        $this->addSql('ALTER TABLE formation DROP visit_card_id, DROP award_level_id, DROP school_id');
        $this->addSql('ALTER TABLE is_apprenticeship DROP FOREIGN KEY FK_4FBCC8985200282E');
        $this->addSql('DROP INDEX UNIQ_4FBCC8985200282E ON is_apprenticeship');
        $this->addSql('ALTER TABLE is_apprenticeship DROP formation_id');
        $this->addSql('ALTER TABLE is_candidate DROP FOREIGN KEY FK_CF4AE32BA76ED395');
        $this->addSql('DROP INDEX UNIQ_CF4AE32BA76ED395 ON is_candidate');
        $this->addSql('ALTER TABLE is_candidate DROP user_id');
        $this->addSql('ALTER TABLE is_recruiter DROP FOREIGN KEY FK_D97E5EB7A76ED395');
        $this->addSql('DROP INDEX UNIQ_D97E5EB7A76ED395 ON is_recruiter');
        $this->addSql('ALTER TABLE is_recruiter DROP user_id');
        $this->addSql('ALTER TABLE is_story DROP FOREIGN KEY FK_A7AAE7487294869C');
        $this->addSql('DROP INDEX UNIQ_A7AAE7487294869C ON is_story');
        $this->addSql('ALTER TABLE is_story DROP article_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('DROP INDEX IDX_8D93D649D60322AC ON user');
        $this->addSql('ALTER TABLE user DROP role_id');
        $this->addSql('ALTER TABLE visit_card DROP FOREIGN KEY FK_C94C6511B103645F');
        $this->addSql('DROP INDEX UNIQ_C94C6511B103645F ON visit_card');
        $this->addSql('ALTER TABLE visit_card DROP is_candidate_id');
        $this->addSql('ALTER TABLE website DROP FOREIGN KEY FK_476F5DE71C459EE7');
        $this->addSql('DROP INDEX IDX_476F5DE71C459EE7 ON website');
        $this->addSql('ALTER TABLE website DROP visit_card_id');
    }
}
