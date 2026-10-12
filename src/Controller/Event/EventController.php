<?php

namespace App\Controller\Event;

use App\Repository\EventRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;
#[Route(path:'/eventAll', name:'eventAll')]
class EventController
{
    public function __invoke(Environment $twig ,EventRepository $eventRepository): Response
    {
        return new Response( $twig->render('Event/event.html.twig',[
           'events'=>$eventRepository->findAll()
        ]), Response::HTTP_OK );
    }
}
