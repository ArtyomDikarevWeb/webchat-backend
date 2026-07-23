<?php
declare(strict_types=1);

namespace App\Enum;

enum ChatParticipantRole: string
{
    case Admin = "chat_admin";
    case User = "chat_user";
}