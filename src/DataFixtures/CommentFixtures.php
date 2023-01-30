<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\DiscoveryDay;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        /** @var DiscoveryDay $discoveryDay */
        $discoveryDay = $this->getReference('2022-12-05');

        for ($i=0; $i<8; $i++) {
            $comment = new Comment();
            $comment->setText($faker->paragraph());
            $comment->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('2022-12-05', 'now')));
            $comment->setDiscoveryDay($discoveryDay);

            /** @var User $user */
            $user = $this->getReference('user_' . $i);
            $comment->setUser($user);

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            RegistrationFixtures::class,
        ];
    }
}