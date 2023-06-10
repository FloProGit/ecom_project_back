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

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

    public function getUser(string $userEmail): array
    {
        //SQL 'SELECT u.name,u.email FROM user u WHERE u.email = :user_email'

        $dql = 'SELECT u.name,u.email
        FROM App\Entity\User u
        WHERE u.email = :user_email';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('user_email', $userEmail);

        return $query->getResult();
    }

    public function updateUserName(string $userEmail,string $name)
    {
        //SQL 'UPDATE user u SET u.name = :user_name  WHERE u.email = :user_email'

        $dql = ' UPDATE App\Entity\User u
        SET u.name = :user_name
        WHERE u.email = :user_email ';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('user_email', $userEmail);
        $query->setParameter('user_name', $name);

        return $query->getResult();
    }

    public function updateUserEmail(string $userEmail,string $newEmail)
    {
        //SQL 'UPDATE user u SET u.email = :new_email  WHERE u.email = :user_email'

        $dql = ' UPDATE App\Entity\User u
        SET u.email = :new_email
        WHERE u.email = :user_email';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('user_email', $userEmail);
        $query->setParameter('new_email', $newEmail);

        return $query->getResult();
    }

    public function updateUserPassword(string $userEmail,string $newPassword)
    {

        //SQL 'UPDATE user u SET u.password = :user_password  WHERE u.email = :user_email'

        $dql = 'UPDATE App\Entity\User u
        SET u.password = :new_password
        WHERE u.email = :user_email';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('user_email', $userEmail);
        $query->setParameter('new_password', $newPassword);

        return $query->getResult();
    }

    public function deleteUser(string $userEmail)
    {
        //SQL 'DELETE FROM user u  WHERE u.email = :user_email'

        $dql = ' DELETE  FROM App\Entity\User u
        WHERE u.email = :user_email';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('user_email', $userEmail);

        return $query->getResult();
    }

}
