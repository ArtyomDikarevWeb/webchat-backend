<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260718171901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migration creates chat participants table and chat participant role ENUM';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TYPE chat_participant_role_type as ENUM (\'chat_user\', \'chat_admin\')');
        $this->addSql('CREATE TABLE chats_participants (
            chat_id BIGINT NOT NULL REFERENCES chats(id),
            user_id BIGINT NOT NULL REFERENCES users(id),
            role chat_participant_role_type NOT NULL DEFAULT \'chat_user\',
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT now(),
            updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT now(),
            deleted_at TIMESTAMP(0) WITHOUT TIME ZONE,
            PRIMARY KEY (chat_id, user_id)
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE chats_participants');
        $this->addSql('DROP TYPE chat_participant_role_type');
    }
}
