<?php

namespace App\EventSubscriber;

use App\Entity\Rank;
use App\Entity\Registration;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

class EntitySubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $em;
    private array $actions;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->actions = [];
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
            Events::postFlush
        ];
    }

    public function schedule(string $action, ...$args): self
    {
        $this->actions[] = [$action, $args];

        return $this;
    }

    public function prePersist(PrePersistEventArgs $event)
    {
        $entity = $event->getObject();

        if (method_exists($entity, 'setCreatedAt')) {
            $entity->setCreatedAt(new \DateTimeImmutable());
        }

        if (method_exists($entity, 'setRequestedAt')) {
            $entity->setRequestedAt(new \DateTimeImmutable());
        }

        if (method_exists($entity, 'setUpdatedAt')) {
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }
    }

    public function preUpdate(PreUpdateEventArgs $event)
    {
        $entity = $event->getObject();

        if (method_exists($entity, 'setUpdatedAt')) {
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }

        if ($entity instanceof Registration && $event->hasChangedField('presence') && $entity->getPresence() === true) {
            $this->schedule('updateUserPoints', $entity->getUser());
        }

        if ($entity instanceof User && $event->hasChangedField('point') && $entity->getRank() !== 'gold') {
            if ($entity->getPoints() >= $entity->getRank()->getRequirement()) {
                $nextRank = $this->em->getRepository(Rank::class)->findUserNextRank($entity->getRank());

                if ($nextRank) {
                    $entity->setRank($nextRank);
                }
            }
        }
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        $actions = $this->actions;
        $this->actions = [];

        foreach ($actions as list($method, $args)) {
            $this->{$method}(...$args);
        }
    }

    private function updateUserPoints(User $user): void
    {
        $user->setPoints($user->getPoints() + 1);

        $this->em->flush();
    }
}