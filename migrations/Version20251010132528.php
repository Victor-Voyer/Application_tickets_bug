<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251010132528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A5774FDDC');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AD6DE06A6');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A700047D2 FOREIGN KEY (ticket_id) REFERENCES tickets (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AF8697D13 FOREIGN KEY (comment_id) REFERENCES comments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images RENAME INDEX idx_e01fbe6a5774fddc TO IDX_E01FBE6A700047D2');
        $this->addSql('ALTER TABLE images RENAME INDEX idx_e01fbe6ad6de06a6 TO IDX_E01FBE6AF8697D13');
        $this->addSql('ALTER TABLE users CHANGE role_id role_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A700047D2');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AF8697D13');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A5774FDDC FOREIGN KEY (ticket_id) REFERENCES tickets (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AD6DE06A6 FOREIGN KEY (comment_id) REFERENCES comments (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE images RENAME INDEX idx_e01fbe6a700047d2 TO IDX_E01FBE6A5774FDDC');
        $this->addSql('ALTER TABLE images RENAME INDEX idx_e01fbe6af8697d13 TO IDX_E01FBE6AD6DE06A6');
        $this->addSql('ALTER TABLE users CHANGE role_id role_id INT DEFAULT 1 NOT NULL');
    }
}
