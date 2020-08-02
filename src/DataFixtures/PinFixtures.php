<?php

namespace App\DataFixtures;

use App\Entity\Pin;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PinFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($z = 1; $z <= 10; $z++) {
            for ($i = 1; $i <= 3; $i++) {
                $pin = new Pin;
                $pin->setTitle('Title ' . $i)
                    ->setDescription('DESCRIPTION ' . $i)
                    ->setUser($this->getReference('user' . $z));
                $manager->persist($pin);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
