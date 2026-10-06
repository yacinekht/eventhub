<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository

/// connecte la class et la base de donner et on doit le faire dans les deux sens c pour ca on a ecrit #entity dans la class
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(?User $user = null){
        $this->getEntityManager()->flush($user);
    }

    public function persist(?User $user = null){
        $this->getEntityManager()->persist($user);
    }

    public function persistAndSave(?User $user = null){
        $this->persist($user);
        $this->save($user);
    }

}
