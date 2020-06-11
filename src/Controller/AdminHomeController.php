<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(UserRepository $userRepository)
    {

        // $userList = $pdo->query("SELECT * from user")->fetchAll();
        $userList = $userRepository->getUsersOnly();


        return $this->render('admin_home/index.html.twig', [
            'user_list' => $userList,
        ]);
    }

}
