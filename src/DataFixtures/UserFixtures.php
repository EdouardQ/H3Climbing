<?php

namespace App\DataFixtures;

use App\Entity\Rank;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $passwordHasher;
    private array $rank = [
        'bronze',
        'silver',
        'gold',
    ];

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $user = new User();
        $user->setEmail('admin@localhost');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'azerty'));
        $user->setFirstName('Admin');
        $user->setLastName('Admin');
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());

        /** @var Rank $rank */
        $rank = $this->getReference('rank_gold');

        $user->setRank($rank);
        $user->setPoints(100);

        $this->addReference('user_0', $user);
        $manager->persist($user);

        for ($i=1; $i < 30; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setPassword($this->passwordHasher->hashPassword($user, 'azerty'));
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 years', 'now')));
            $user->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 years', 'now')));

            /** @var Rank $rank */
            $rank = $this->getReference('rank_' . $this->rank[$faker->numberBetween(0, 2)]);

            $user->setRank($rank);
            $user->setPoints($rank->getRequirement());

            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            RankFixtures::class,
        ];
    }
}