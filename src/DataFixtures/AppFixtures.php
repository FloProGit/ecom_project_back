<?php

namespace App\DataFixtures;

use App\Entity\ConditionProduct;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasherInterface){
        $this->passwordHasher = $passwordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        $manager->persist($this->CreateUser(
            'SuperAdmin',
            'admin@gmail.com',
            ['ROLE_SUPER_ADMIN']
        ));
        $manager->persist($this->CreateUser(
            'admin',
            'useradmin23@gmail.com',
            ["ROLE_ADMIN"]
        ));
        $manager->persist($this->CreateUser(
            'Guest',
            'guest@gmail.com',
            ["ROLE_USER"]
        ));
        $manager->persist($this->CreateCondition("REFURBISHED_A_PLUS"));
        $manager->persist($this->CreateCondition("NEW"));
        $manager->flush();
    }
    public function CreateCondition(string $value):ConditionProduct
    {
        $condition = new ConditionProduct();
        $condition->setCurrentCondition($value);
        return $condition;
    }

    public function CreateUser( string $name, string $email, array $roles) :User
    {
        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setRoles($roles);
        $plaintextPassword = 'azerty1234';
        $user->setPassword($this->passwordHasher->hashPassword($user, $plaintextPassword));
        $user->setCreatedAt(new \DateTimeImmutable('now'));
        $user->setUpdatedAt(new \DateTimeImmutable('now'));
        $user->setEmailVerifiedAt(new \DateTimeImmutable('now'));

        return $user;
    }
}
