<?php

namespace App\Repository;

use App\Entity\Registration;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Registration>
 *
 * @method Registration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Registration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Registration[]    findAll()
 * @method Registration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegistrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Registration::class);
    }

    public function save(Registration $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Registration $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findUpcomingDiscoveryDays(User $user): array
    {
        return $this->createQueryBuilder('r')
            ->join('r.discoveryDay', 'd', 'WITH', 'r.discoveryDay >= d.id')
            ->andWhere('r.user = :user')
            ->andWhere('d.date >= :date')
            ->setParameters([
                'user' => $user,
                'date' => new \DateTime(),
            ])
            ->orderBy('d.date', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findPastDiscoveryDays(User $user): array
    {
        return $this->createQueryBuilder('r')
            ->join('r.discoveryDay', 'd', 'WITH', 'r.discoveryDay >= d.id')
            ->andWhere('r.user = :user')
            ->andWhere('d.date < :date')
            ->setParameters([
                'user' => $user,
                'date' => new \DateTime(),
            ])
            ->orderBy('d.date', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
