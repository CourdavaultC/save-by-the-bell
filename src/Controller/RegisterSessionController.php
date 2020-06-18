<?php

namespace App\Controller;

use App\Entity\HalfJourney;
use App\Form\CreateSessionType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(Request $request, SessionRepository $sessionRepository, EntityManagerInterface $entityManager)
    {
        $session = new Session();
        $form = $this->createForm(CreateSessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date=$session->getDateStart();
            $date_end=$session->getDateEnd();

            while ($date<$date_end) {

                if($date->format('l') == 'Sunday' || $date->format('l') == 'Saturday')
                {
                    $date=$date->add(\DateInterval::createFromDateString('1 days'));
                    continue;
                }
                $half_journey_morning= new HalfJourney();
                $half_journey_morning->setSession($session);
                $half_journey_morning->setPeriod('morning');
                $half_journey_morning->setHalfDate($date);

                $half_journey_afternoon= new HalfJourney();
                $half_journey_afternoon->setSession($session);
                $half_journey_afternoon->setPeriod('afternoon');
                $half_journey_afternoon->setHalfDate($date);

                $date=$date->add(\DateInterval::createFromDateString('1 days'));

                $entityManager->persist($half_journey_morning);
                $entityManager->persist($half_journey_afternoon);
            }


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
