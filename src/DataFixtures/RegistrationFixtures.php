<?php

namespace App\DataFixtures;

use App\Entity\DiscoveryDay;
use App\Entity\Registration;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RegistrationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $registration = new Registration();
        $registration->setRequestedAt(new \DateTimeImmutable());
        $registration->setUpdatedAt(new \DateTimeImmutable());
        $registration->setValidated(true);

        /** @var User $user */
        $user = $this->getReference('user_0');
        $registration->setUser($user);

        /** @var DiscoveryDay $discoveryDay */
        $discoveryDay = $this->getReference('discovery_day');
        $registration->setDiscoveryDay($discoveryDay);

        $manager->persist($registration);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            DiscoveryDayFixtures::class,
            UserFixtures::class,
        ];
    }
}
