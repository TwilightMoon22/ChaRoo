<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203095252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participantes (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, chat_id INT NOT NULL, UNIQUE INDEX UNIQ_19E6E1C4A76ED395 (user_id), UNIQUE INDEX UNIQ_19E6E1C41A9A7125 (chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participantes ADD CONSTRAINT FK_19E6E1C4A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE participantes ADD CONSTRAINT FK_19E6E1C41A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participantes DROP FOREIGN KEY FK_19E6E1C4A76ED395');
        $this->addSql('ALTER TABLE participantes DROP FOREIGN KEY FK_19E6E1C41A9A7125');
        $this->addSql('DROP TABLE participantes');
    }
}
