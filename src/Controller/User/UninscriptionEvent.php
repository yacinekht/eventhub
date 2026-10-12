<?php

namespace App\Controller\User;
use App\Entity\Registration;
use App\Repository\EventRepository;
use App\Service\RegistrationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Twig\Environment;

#[Route(path: '/inscriptions/{slug}/desinscription', name: 'uninscriptionEvent')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class UninscriptionEvent extends AbstractController
{

    public function __invoke(
        string $slug,
        Security $security,
        EventRepository $eventRepository,
        EntityManagerInterface $entityManager,
        Request $request,
        RegistrationService $registrationService
    ): Response {
        // 1. Récupérer l'utilisateur connecté
        $user = $security->getUser();

        // 2. Récupérer l'événement concerné
        $event = $eventRepository->findOneBy(['slug' => $slug]);

//        $registration=$entityManager-> getRepository(Registration::class)->findOneBy([
//            'user'=>$user,
//            'event'=>$event
//        ]);

        $success=$registrationService->UnRegister($user,$event);

        if(!$success){
            $this->addFlash(
                'warning',
                "Tu n'es pas désinscrit de cet événement."
            );
        }
//        $entityManager->remove($registration);
//        $entityManager->flush();

        $this->addFlash(
            'success',
            'Tu es désinscrit de cet événement.'
        );

        return $this->redirectToRoute('inscriptions');
    }

}
