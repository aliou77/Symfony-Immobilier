<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;

/**
 * @CodeCoverageIgnore
 */
class UserFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface  $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager ): void
    {
        // $user = new User();
        // $user
        //     ->setUsername('mamadou@gmail.com')
        //     ->setEmail("mamadou@gmail.com")
        //     ->setPassword($this->hasher->hashPassword($user, 'mamadou'));
        // ;
        // $manager->persist($user);
        // $manager->flush();
    }
}
