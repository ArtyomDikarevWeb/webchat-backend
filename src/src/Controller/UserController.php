<?php
declare(strict_types=1);

namespace App\Controller;

use App\DTO\UserDTO;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UserController
{
    #[Route('/api/register', methods: ['POST'], name: 'register')]
    public function register(Request $request, UserRepository $userRepository): JsonResponse
    {
        $email = $request->getPayload()->get("email");
        $username = $request->getPayload()->get("username");
        $password = $request->getPayload()->get("password");
        $userDTO = new UserDTO($email, $username, $password);

        $userRepository->create($userDTO);

        return new JsonResponse(['success' => true], 204);
    }
}