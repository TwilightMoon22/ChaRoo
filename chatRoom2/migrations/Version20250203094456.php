<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203094456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participantes (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participantes_user (participantes_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_948FCB1EFEEB7E55 (participantes_id), INDEX IDX_948FCB1EA76ED395 (user_id), PRIMARY KEY(participantes_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participantes_chat (participantes_id INT NOT NULL, chat_id INT NOT NULL, INDEX IDX_7C81EFFDFEEB7E55 (participantes_id), INDEX IDX_7C81EFFD1A9A7125 (chat_id), PRIMARY KEY(participantes_id, chat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participantes_user ADD CONSTRAINT FK_948FCB1EFEEB7E55 FOREIGN KEY (participantes_id) REFERENCES participantes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participantes_user ADD CONSTRAINT FK_948FCB1EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participantes_chat ADD CONSTRAINT FK_7C81EFFDFEEB7E55 FOREIGN KEY (participantes_id) REFERENCES participantes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participantes_chat ADD CONSTRAINT FK_7C81EFFD1A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participantes_user DROP FOREIGN KEY FK_948FCB1EFEEB7E55');
        $this->addSql('ALTER TABLE participantes_user DROP FOREIGN KEY FK_948FCB1EA76ED395');
        $this->addSql('ALTER TABLE participantes_chat DROP FOREIGN KEY FK_7C81EFFDFEEB7E55');
        $this->addSql('ALTER TABLE participantes_chat DROP FOREIGN KEY FK_7C81EFFD1A9A7125');
        $this->addSql('DROP TABLE participantes');
        $this->addSql('DROP TABLE participantes_user');
        $this->addSql('DROP TABLE participantes_chat');
    }
}
