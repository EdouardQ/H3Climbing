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
    private array $data = [
        [
            'requestedAt' => '2023-01-01',
            'updatedAt' => '2023-01-01',
            'validated' => true,
            'discoveryDay' => '2023-02-01',
        ],
        [
            'requestedAt' => '2022-12-01',
            'updatedAt' => '2022-12-01',
            'validated' => true,
            'discoveryDay' => '2022-12-05',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        /** @var User $user */
        $user = $this->getReference('user_0');

        foreach ($this->data as $registration)
        {
            $entity = new Registration();
            $entity->setUser($user);
            $entity->setRequestedAt(new \DateTimeImmutable($registration['requestedAt']));
            $entity->setUpdatedAt(new \DateTimeImmutable($registration['updatedAt']));
            $entity->setValidated($registration['validated']);

            /** @var DiscoveryDay $discoveryDay */
            $discoveryDay = $this->getReference($registration['discoveryDay']);
            $entity->setDiscoveryDay($discoveryDay);

            $manager->persist($entity);
        }

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
