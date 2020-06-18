<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\HalfJourneyRepository;
use App\Repository\SessionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ListSessionController extends AbstractController
{
    /**
     * @Route("/admin/ajax/presences/{id}", name="ajax_presences")
     */
    public function listPresencesforTodaysSession(Session $session, UserRepository $userRepository, HalfJourneyRepository $halfJourneyRepository) {
        $userList = $userRepository->getUsersOnlyBySession($session);
        $halfJourneyMorning = $halfJourneyRepository->findOneBy(array(
            'period'=>'morning',
            'session'=>$session,
            'half_date'=>(new \DateTime())
        ));

        $halfJourneyAfternoon = $halfJourneyRepository->findOneBy(array(
            'period'=>'afternoon',
            'session'=>$session,
            'half_date'=>(new \DateTime())
        ));
        return $this->render('admin_home/presences_in_sessions.html.twig', [
            'user_list' => $userList,
            'half_journey_morning' => $halfJourneyMorning,
            'half_journey_afternoon' => $halfJourneyAfternoon
        ]);
    }
}
