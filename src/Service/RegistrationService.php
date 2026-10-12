<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\Registration;
use App\Entity\User;
use App\Enum\RegistrationStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class RegistrationService
{

    public function __construct(private EntityManagerInterface $entityManager, private SluggerInterface $slugger){}

    public function Register(User $user,Event $event){


        $ExistingRegistration=$this->entityManager-> getRepository(Registration::class)->findOneBy([
            'user'=>$user,
            'event'=>$event
        ]);

        if ($ExistingRegistration) {
            return false;
        }

        $Registration= new Registration(RegistrationStatus::Confirmed);
        $Registration->setUser($user);
        $Registration->setEvent($event);
        $Registration->setCreatedAt(new \DateTimeImmutable());


        $this->entityManager->persist($Registration);
        $this->entityManager->flush();


        return true;

    }

    public function UnRegister(User $user,Event $event){


        $registration=$this->entityManager-> getRepository(Registration::class)->findOneBy([
            'user'=>$user,
            'event'=>$event
        ]);

        if(!$registration){
            return false;
        }

        $this->entityManager->remove($registration);
        $this->entityManager->flush();
        return true;
    }

    public function creatEvent(User $user, Event $event){
        $event->setOrganizer($user);


            $event->setSlug(
                strtolower($this->slugger->slug($event->getTitle()))
            );

            if(!$user instanceof User){
                throw new \Exception('interdit');
            }

            $this->entityManager->persist($event);
            $this->entityManager->flush();

        }
}
