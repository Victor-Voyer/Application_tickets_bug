<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251001093741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments ADD ticket_id INT NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A700047D2 FOREIGN KEY (ticket_id) REFERENCES tickets (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A700047D2 ON comments (ticket_id)');
        $this->addSql('ALTER TABLE comments RENAME INDEX idx_5f9e962a9d86650f TO IDX_5F9E962AA76ED395');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A5774FDDC');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AD6DE06A6');
        $this->addSql('DROP INDEX IDX_E01FBE6A5774FDDC ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6AD6DE06A6 ON images');
        $this->addSql('ALTER TABLE images ADD ticket_id_id INT DEFAULT NULL, ADD comment_id_id INT DEFAULT NULL, DROP ticket_id, DROP comment_id');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A5774FDDC FOREIGN KEY (ticket_id_id) REFERENCES tickets (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AD6DE06A6 FOREIGN KEY (comment_id_id) REFERENCES comments (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A5774FDDC ON images (ticket_id_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AD6DE06A6 ON images (comment_id_id)');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF463379586');
        $this->addSql('DROP INDEX IDX_54469DF463379586 ON tickets');
        $this->addSql('ALTER TABLE tickets DROP comments_id');
        $this->addSql('ALTER TABLE tickets RENAME INDEX idx_54469df49d86650f TO IDX_54469DF4A76ED395');
        $this->addSql('ALTER TABLE users CHANGE role_id role_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A700047D2');
        $this->addSql('DROP INDEX IDX_5F9E962A700047D2 ON comments');
        $this->addSql('ALTER TABLE comments DROP ticket_id');
        $this->addSql('ALTER TABLE comments RENAME INDEX idx_5f9e962aa76ed395 TO IDX_5F9E962A9D86650F');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A5774FDDC');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AD6DE06A6');
        $this->addSql('DROP INDEX IDX_E01FBE6A5774FDDC ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6AD6DE06A6 ON images');
        $this->addSql('ALTER TABLE images ADD ticket_id INT DEFAULT NULL, ADD comment_id INT DEFAULT NULL, DROP ticket_id_id, DROP comment_id_id');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A5774FDDC FOREIGN KEY (ticket_id) REFERENCES tickets (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AD6DE06A6 FOREIGN KEY (comment_id) REFERENCES comments (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E01FBE6A5774FDDC ON images (ticket_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AD6DE06A6 ON images (comment_id)');
        $this->addSql('ALTER TABLE users CHANGE role_id role_id INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE tickets ADD comments_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF463379586 FOREIGN KEY (comments_id) REFERENCES comments (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_54469DF463379586 ON tickets (comments_id)');
        $this->addSql('ALTER TABLE tickets RENAME INDEX idx_54469df4a76ed395 TO IDX_54469DF49D86650F');
    }
}
