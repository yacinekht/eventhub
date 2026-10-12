<?php

namespace App\Controller\User;

use App\Repository\EventRepository;





use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\SecurityBundle\Security;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Twig\Environment;

#[Route(path: '/inscriptions', name: 'inscriptions')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class Inscription
{

    public function __invoke(Environment $twig,Security $security,RouterInterface $router, EventRepository $eventRepository,EntityManagerInterface $entityManager):Response{

        $user=$security->getUser();


        return new Response($twig->render('user/inscription.html.twig', [
            'registrations' => $user->getRegistrations(),
        ]));    }
}
