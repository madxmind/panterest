<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $user = new User;
            $user->setEmail('user' . $i . '@gmail.com')
                ->setFirstName('Firstname' . $i)
                ->setLastName('Lastname' . $i)
                ->setPassword($this->userPasswordEncoder->encodePassword($user, 'password'));
            $manager->persist($user);

            $this->setReference('user' . $i, $user);
        }

        $manager->flush();
    }
}
