<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'adminpw'));
        $user->setFirstName('Ima');
        $user->setLastName('Administrator');
        $user->setRoles(['ROLE_USER','ROLE_ADMIN','ROLE_ALLOWED_TO_SWITCH']);
        $user->setEmail('admin@fakedn.org');
        $manager->persist($user);

        UserFactory::createMany(10);

        $manager->flush();
    }
}
