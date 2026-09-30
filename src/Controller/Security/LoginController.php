<?php

declare(strict_types=1);

namespace App\Controller\Security;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

#[Route('/login', name: 'app_login')]
class LoginController
{
    public function __invoke(AuthenticationUtils $authenticationUtils,
                             Environment $twig): Response
    {
        return new Response($twig->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),  // ca c un outils directement integrer dans symfony qui gere authentification on 'lutilise par contre c ecrit user parceque l'outil est comme ca y'a pas email mais tkt pas on la associer a l'email dans le security.yaml donc c associer et quand tu te connecte ca va prendre en conte ton email tkt .
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]), Response::HTTP_OK);
    }
}
