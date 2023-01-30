<?php

namespace App\DataFixtures;

use App\Entity\DiscoveryDay;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DiscoveryDayFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $discoveryDay = new DiscoveryDay();
        $discoveryDay->setDate(new \DateTime('2023-02-01'));
        $discoveryDay->setCreatedAt(new \DateTimeImmutable());
        $discoveryDay->setLocation('88 Bd Gallieni, 92130 Issy-les-Moulineaux, France');
        $discoveryDay->setMaxParticipant(10);

        /** @var User $organizer */
        $organizer = $this->getReference('user_0');
        $discoveryDay->setOrganizer($organizer);

        // $this->addReference('discovery_day', $discoveryDay);
        $manager->persist($discoveryDay);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}