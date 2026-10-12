<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Entity\User;
use App\Form\Event\EventType;
use App\Repository\EventRepository;

use App\Service\RegistrationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Exception\LogicException;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Environment;
use Symfony\Bundle\SecurityBundle\Security;

#[AsController]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_ORGANIZER")'))]
#[Route(path: '/NewEvent', name:'NewEvent')]
class NewEvent
{
    public function __invoke(Environment $twig,RegistrationService $registrationService,RouterInterface $router,Security $security, FormFactoryInterface $formFactory ,SluggerInterface $slugger,EntityManagerInterface $entityManager,Request $request, EventRepository $eventRepository ): Response
    {
        $user=$security->getUser();
        $event= new event();
        $form=$formFactory->create(EventType::class,$event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
//            $event->setOrganizer($user);
            $event=$form->getData();

            $registrationService->creatEvent($user,$event);

            $this->addFlash('success', "L'événement a été créé avec succès !");
//            try{
                $event=$form->getData();
//                $event->setSlug(
//                    strtolower($slugger->slug($event->getTitle()))
//                );
//
//                if(!$user instanceof User){
//                    throw new \Exception('interdit');
//                }
//
//                $entityManager->persist($event);
//                $entityManager->flush();



                return new RedirectResponse($router->generate('eventAll'))  ;

//            }catch(LogicException $e){
//
//            }


        }


        return new Response($twig->render('Event/NewEvent.html.twig',[
                'form'=>$form->createView()
        ]));
    }
}
