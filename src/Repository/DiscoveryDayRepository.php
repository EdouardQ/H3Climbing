<?php

namespace App\Repository;

use App\Entity\DiscoveryDay;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DiscoveryDay>
 *
 * @method DiscoveryDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiscoveryDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiscoveryDay[]    findAll()
 * @method DiscoveryDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscoveryDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiscoveryDay::class);
    }

    public function save(DiscoveryDay $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DiscoveryDay $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findUpcomingDiscoveryDays(): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.date >= :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('d.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPastDiscoveryDays(): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.date < :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('d.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findManagebleDiscoveryDays(User $user): array
    {
        return $this->createQueryBuilder('d')
            ->join('d.registrations', 'r', 'WITH', 'r.discoveryDay = d.id')
            ->andWhere('d.organizer = :organizer')
            ->andWhere('r.presence IS NULL')
            ->setParameter('organizer', $user)
            ->orderBy('d.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
