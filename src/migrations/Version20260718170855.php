<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260718170855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migration creates chats table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TYPE chat_type as ENUM (\'user_chat\', \'support_chat\')');
        $this->addSql('CREATE TABLE chats (
            id BIGINT NOT NULL,
            type chat_type NOT NULL DEFAULT \'user_chat\',
            name varchar(225) DEFAULT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT now(),
            updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT now(),
            deleted_at TIMESTAMP(0) WITHOUT TIME ZONE,
            PRIMARY KEY (id)
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE chats');
        $this->addSql('DROP TYPE chat_type');
    }
}
