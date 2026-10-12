<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Entity\User;
use App\Form\Event\EditEventType;


use LogicException;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;

#[AsController]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_ORGANIZER")'))]
#[Route(path: '/editevent/{slug}', name: 'editevent')]
class EditEven
{

    public function __invoke(Event $event, Environment $twig,Security $security, FormFactoryInterface $formFactory,
                                Request $request,UrlGeneratorInterface $router,SluggerInterface $slugger, EntityManagerInterface $entityManager ):Response
    {
        $user=$security->getUser();
        $form=$formFactory->create(EditEventType::class , $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $event->setOrganizer($user);

            Try{
                $event->setslug(strtolower($slugger->slug($event->getTitle())));

                if(!$user instanceof User){
                    throw new \Exception('interdit');
                }

                $entityManager->persist($event);
                $entityManager->flush();

                return new RedirectResponse($router->generate('eventAll'))  ;



            }catch(LogicException $e){}
        }


        return new Response($twig->Render('/Event/editEvent.html.twig', [
            'form'=>$form->createView(),
            'event'=>$event,
        ]));
    }

}
