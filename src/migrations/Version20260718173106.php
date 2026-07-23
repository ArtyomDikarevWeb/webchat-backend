<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260718173106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migration creates messages table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE messages (
            chat_id BIGINT NOT NULL REFERENCES chats(id),
            user_id BIGINT NOT NULL REFERENCES users(id),
            text TEXT NOT NULL, 
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT now(),
            updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT now(),
            deleted_at TIMESTAMP(0) WITHOUT TIME ZONE,
            PRIMARY KEY (chat_id, user_id, created_at)
        ) PARTITION BY RANGE (created_at)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE messages');
    }
}
