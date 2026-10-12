<?php

namespace App\Controller\User;
use App\Entity\Registration;
use App\Enum\RegistrationStatus;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;


use App\Service\RegistrationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Twig\Environment;

#[Route(path: '/inscriptionsEvent/{slug}', name: 'inscriptionsEvent')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class InscriptionEvent extends AbstractController
{

    public function __invoke(Environment $twig,RegistrationService $registrationService, $security,RouterInterface $router,string $slug, EventRepository $eventRepository,EntityManagerInterface $entityManager):Response{

        $user=$security->getUser();
        $event=$eventRepository->findOneBy(['slug'=>$slug]);

        if (!$event) {
            throw $this->createNotFoundException('Événement introuvable.');
        }

        if (!$user) {
            throw $this->createAccessDeniedException("Vous n'êtes pas connecté.");
        }

        $success=$registrationService->Register($user,$event);


//        $ExistingRegistration=$entityManager-> getRepository(Registration::class)->findOneBy([
//            'user'=>$user,
//            'event'=>$event
//        ]);

        if (!$success) {
            $this->addFlash('warning', 'Tu es déjà inscrit à cet événement.');

            return new RedirectResponse($router->generate('homepage'))  ;
        }else{
            $this->addFlash('success', 'UninscriptionEvent effectuée avec succès !');
        }


//        $Registration= new Registration(RegistrationStatus::Confirmed);
//        $Registration->setUser($user);
//        $Registration->setEvent($event);
//        $Registration->setCreatedAt(new \DateTimeImmutable());
//
//
//        $entityManager->persist($Registration);
//        $entityManager->flush();
//
//        $this->addFlash('success', 'UninscriptionEvent effectuée avec succès !');


        return new Response($twig->render('user/inscription.html.twig', [
            'registrations' => $user->getRegistrations(),
        ]));    }
}
