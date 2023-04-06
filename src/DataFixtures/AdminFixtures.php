<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class AdminFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        )
    {}


    public function load(ObjectManager $manager): void
    {
        $this->createAdmin('admin@test.com', 'Admin', 'Admin', $manager);
        $manager->flush();
    }

    public function createAdmin(
        string $email,
        string $name,
        string $firstname,
        ObjectManager $manager
        )
    {
        $admin = new User();
        $admin->setEmail($email);
        $admin->setName($name);
        $admin->setFirstname($firstname);
        $admin->setIsVerified(1);
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'secret')
        );
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

    }
}
