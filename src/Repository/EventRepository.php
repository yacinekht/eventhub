<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\User;
use App\Enum\EventStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findEventsPublished(): array
    {
        $query=$this->createQueryBuilder('e')
            ->andWhere('e.status=:status')
            ->setParameter('status',EventStatus::Published);

        return $query->getQuery()->getResult();
    }

    public function findYourEvent(User $user){
        $query=$this->createQueryBuilder('e')
            ->andWhere('e.organizer=:organizer')
            ->setParameter('organizer',$user);

        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Event[] Returns an array of Event objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
