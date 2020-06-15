<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListSessionController extends AbstractController
{
    /**
     * @Route("admin/list/session", name="list_session")
     */
    public function index()
    {
        return $this->render('list_session/index.html.twig', [
            'controller_name' => 'ListSessionController',
        ]);
    }
}
