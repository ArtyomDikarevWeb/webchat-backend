<?php
declare(strict_types=1);

namespace App\Enum;

enum ChatType: string
{
    case Support = "support_chat";
    case User = "user_chat";
}