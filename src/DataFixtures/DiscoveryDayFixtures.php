<?php

namespace App\DataFixtures;

use App\Entity\DiscoveryDay;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DiscoveryDayFixtures extends Fixture implements DependentFixtureInterface
{
    private array $data = [
        [
            'title' => 'Discovery Day 1',
            'date' => '2022-12-05',
            'createdAt' => '2022-12-01',
            'location' => '88 Bd Gallieni, 92130 Issy-les-Moulineaux, France',
            'maxParticipant' => 5,
            'minimumRank' => 'bronze',
        ],
        [
            'title' => 'Discovery Day 2',
            'date' => 'now',
            'createdAt' => 'now',
            'location' => '88 Bd Gallieni, 92130 Issy-les-Moulineaux, France',
            'maxParticipant' => 10,
            'minimumRank' => 'bronze'
        ],
        [
            'title' => 'Discovery Day 3',
            'date' => '2023-02-20',
            'createdAt' => '2023-01-01',
            'location' => '88 Bd Gallieni, 92130 Issy-les-Moulineaux, France',
            'maxParticipant' => 10,
            'minimumRank' => 'bronze'
        ]
    ];

    public function load(ObjectManager $manager)
    {
        /** @var User $organizer */
        $organizer = $this->getReference('user_0');

        foreach ($this->data as $discoveryDay)
        {
            $entity = new DiscoveryDay();
            $entity->setTitle($discoveryDay['title']);
            $entity->setDate(new \DateTimeImmutable($discoveryDay['date']));
            $entity->setCreatedAt(new \DateTimeImmutable($discoveryDay['createdAt']));
            $entity->setLocation($discoveryDay['location']);
            $entity->setMaxParticipant($discoveryDay['maxParticipant']);
            $entity->setOrganizer($organizer);
            $entity->setMinimumRank($this->getReference('rank_' . $discoveryDay['minimumRank']));

            $this->addReference($discoveryDay['date'], $entity);
            $manager->persist($entity);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}