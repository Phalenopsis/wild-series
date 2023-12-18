<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    private const USERS = [
        ['email' => 'user@site.com', 'password' => 'plopuser', 'roles' => ['ROLE_USER']],
        ['email' => 'admin@site.com', 'password' => 'plopadmin', 'roles' => ['ROLE_ADMIN']],
    ];

    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        // $product = new Product();
        // $manager->persist($product);

        foreach (self::USERS as $user){
            $newUser = new User();
            $newUser->setEmail($user['email']);
            $newUser->setRoles($user['roles']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $newUser,
                $user['password'],
            );
            $newUser->setPassword($hashedPassword);
            $manager->persist($newUser);
        }

        $manager->flush();
    }
}
