<?php

namespace App\Controller\Event;

use App\Repository\EventRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Twig\Environment;
#[AsController]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_ORGANIZER")'))]
#[Route(path: '/yourevent', name:'yourevent')]
class SeeYourEvent
{
    public function __invoke(Environment $twig,Security $security, EventRepository $eventRepository ): Response
    {
        $user = $security->getUser();

        return new Response($twig->render('Event/yourevent.html.twig',[
            'event'=>$eventRepository->findYourEvent($user)
        ]));
    }

}
