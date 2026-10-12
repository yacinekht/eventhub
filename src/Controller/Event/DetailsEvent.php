<?php

namespace App\Controller\Event;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[Route(path: '/detailsEvent/{slug}', name: 'detailsEvent')]
class DetailsEvent
{
    public function __invoke(Environment $twig, EventRepository $eventRepository, string $slug ): Response{
        return new Response($twig->render('Event/details_event.html.twig',[
            'event'=>$eventRepository->findOneBy(['slug'=>$slug])

        ]));
    }
}
