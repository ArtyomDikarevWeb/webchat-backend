<?php
declare(strict_types=1);

namespace App\DTO;

class UserDTO
{
    public function __construct(
        public string $email,
        public string $username,
        public string $password,
    )
    {
        
    }
}