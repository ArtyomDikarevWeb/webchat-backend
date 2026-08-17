<?php

namespace App\Repository;

use App\Entity\User;
use App\DTO\UserDTO;
use App\Enum\UserRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private UserPasswordHasherInterface $passwordHasher,
        private LoggerInterface $log,
    )
    {
        parent::__construct($registry, User::class);
    }

    public function create(UserDTO $userDto)
    {
        try {
            $entityManager = $this->getEntityManager();
            $user = new User();
            $user->setUsername($userDto->username);
            $hashedPassword = $this->passwordHasher->hashPassword($user, $userDto->password);
            $user->setPassword($hashedPassword);
            $user->setEmail($userDto->email);

            $entityManager->persist($user);
            $entityManager->flush();
        } catch (\Error $e) {
            $this->log->critical("User was not saved", [
                "inputData" => [
                    "username" => $userDto->username, 
                    "hashedPassword" => $hashedPassword,
                    "password" => $userDto->password,
                    "email" => $userDto->email,
                ],
                "exceptionData" => [
                    "message" => $e->getMessage(),
                    "code" => $e->getCode(),
                ], 
            ]);
            throw new HttpException(500, 'User was not saved');
        }
    }

    public function getAllUsers()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT * FROM users';

        $resultSet = $conn->executeQuery($sql);

        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

       public function findOneByEmail($value): ?User
       {
           return $this->createQueryBuilder('u')
               ->andWhere('u.email = :val')
               ->setParameter('val', $value)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->findOneBy(['username' => $identifier]);
        
        if (!$user) {
            throw new UserNotFoundException(sprintf('User with username "%s" not found.', $identifier));
        }
        
        return $user;
    }
}
