<?php

namespace App\Controller;

use App\Form\CreateSessionType;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Session;
use Symfony\Component\Routing\Annotation\Route;

class RegisterSessionController extends AbstractController
{
    /**
     * @Route("/admin/session", name="register_session")
     */
    public function index(Request $request, SessionRepository $sessionRepository, Session $session = null)
    {
        $session = new Session();
        $form = $this->createForm(CreateSessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $session->addHalfJourney('');

            // date start
            // date end
            // Ajouter toutes les 1/2 journées


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            $entityManager->flush();

            // do anything else you need here, like send an email
            $this->addFlash(
                'notice',
                'La session a bien été enregistré'
            );

            return $this->redirectToRoute('admin_home');
        }


        return $this->render('register_session/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
