<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
* @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    // Method custom pour update le Role du user.

    public function updateUserRoles(int $userId, array $roles): void
    {
        $entityManager = $this->getEntityManager();
        $user = $entityManager->getReference(User::class, $userId);

        // Supprimer le rôle "ROLE_USER" s'il est présent dans la liste des rôles
        $userRoles = $user->getRoles();
        $key = array_search('ROLE_USER', $userRoles);
        if ($key !== false) {
            unset($userRoles[$key]);
        }

        // Ajouter le rôle "ROLE_ADMIN" à la liste des rôles
        $userRoles[] = 'ROLE_ADMIN';

        // Mettre à jour les rôles de l'utilisateur
        $user->setRoles($userRoles);

        // Persistez les changements dans la base de données
        $entityManager->flush();
    }

    // Method custom pour récuperer les donations a partir du nom et prénom d'un utilisateur

    public function findByDonorName($firstName, $lastName)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.donorFirstName = :firstName')
            ->andWhere('d.donorLastName = :lastName')
            ->setParameter('firstName', $firstName)
            ->setParameter('lastName', $lastName)
            ->getQuery()
            ->getResult();
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

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
