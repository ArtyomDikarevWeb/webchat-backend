<?php
declare(strict_types=1);

namespace App\Controller;

use App\DTO\UserDTO;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class UserController
{
    #[Route('/api/register', methods: ['POST'], name: 'users.register')]
    public function register(#[MapRequestPayload] UserDTO $dto, UserRepository $userRepository): JsonResponse
    {
        $userRepository->create($dto);

        return new JsonResponse(['success' => true], 204);
    }
}