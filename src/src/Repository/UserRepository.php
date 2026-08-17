<?php

namespace App\Repository;

use App\Entity\User;
use App\DTO\UserDTO;
use App\Enum\UserRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
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
        private UserPasswordHasherInterface $passwordHasher
    )
    {
        parent::__construct($registry, User::class);
    }

    public function create(UserDTO $userDto)
    {
        $user = new User();
        $user->setUsername($userDto->username);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $userDto->password);
        $user->setPassword($hashedPassword);
        $user->setEmail($userDto->email);

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
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
