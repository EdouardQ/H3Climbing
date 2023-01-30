<?php

namespace App\DataFixtures;

use App\Entity\Rank;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RankFixtures extends Fixture
{
    private array $data = [
        [
            'name' => 'bronze',
            'requirement' => 0,
        ],
        [
            'name' => 'silver',
            'requirement' => 10,
        ],
        [
            'name' => 'gold',
            'requirement' => 30,
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $data) {
            $rank = new Rank();
            $rank->setName($data['name']);
            $rank->setRequirement($data['requirement']);

            $this->addReference('rank_' . $data['name'], $rank);
            $manager->persist($rank);
        }

        $manager->flush();
    }
}