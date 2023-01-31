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
            'requestedAt' => '2022-12-01',
            'updatedAt' => '2022-12-01',
            'present' => true,
            'discoveryDay' => '2022-12-05',
        ],
        [
            'requestedAt' => 'now',
            'updatedAt' => 'now',
            'present' => null,
            'discoveryDay' => 'now',
        ],
        [
            'requestedAt' => '2023-01-01',
            'updatedAt' => '2023-01-01',
            'present' => null,
            'discoveryDay' => '2023-02-20',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $registration) {
            /** @var DiscoveryDay $discoveryDay */
            $discoveryDay = $this->getReference($registration['discoveryDay']);

            for ($i=0; $i<5; $i++) {
                $entity = new Registration();
                $entity->setRequestedAt(new \DateTimeImmutable($registration['requestedAt']));
                $entity->setUpdatedAt(new \DateTimeImmutable($registration['updatedAt']));
                $entity->setPresent($registration['present']);
                $entity->setDiscoveryDay($discoveryDay);

                /** @var User $user */
                $user = $this->getReference('user_' . $i);
                $entity->setUser($user);

                $manager->persist($entity);
            }
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
