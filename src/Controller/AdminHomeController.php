<?php

namespace App\Controller;

use App\Entity\Presences;
use App\Entity\Session;
use App\Entity\User;
use App\Repository\HalfJourneyRepository;
use App\Repository\SessionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{
    /**
     * @Route("/admin/{id<\d+>}", defaults={"id"=null}, name="admin_home")
     */
    public function index(HalfJourneyRepository $halfJourneyRepository, UserRepository $userRepository, SessionRepository $sessionRepository, Session $session = null)
    {

        // $userList = $pdo->query("SELECT * from user")->fetchAll();
        if ($session === null) {
            $userList = array();
        } else {
            $userList = $userRepository->getUsersOnlyBySession($session);
        }

        $sessList = $sessionRepository->findAll();
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


        return $this->render('admin_home/index.html.twig', [
            'user_list' => $userList,
            'session_actuelle' => $session,
            'session_list' => $sessList,
            'half_journey_morning' => $halfJourneyMorning,
            'half_journey_afternoon'=> $halfJourneyAfternoon
        ]);
    }

}
