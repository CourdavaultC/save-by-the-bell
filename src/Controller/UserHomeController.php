<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Cassandra\Type\UserType;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserHomeController extends AbstractController
{
    /**
     * @Route("/user", name="user_home")
     */
    public function index(UserRepository $userRepository)
    {
        return $this->render('user_home/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/user/{id<\d+>}", name="user")
     */
    public function detail(User $user = null)
    {
        // si on n'a pas de contrôleur, cela signifie qu'on est passé par le profil
        if( $user === null ) {
            // on récupère l'utilisateur connecté
            $user = $this->getUser();
        }
        // si malgré tout on n'a pas réussi à récupérer un utilisateur
        // on redirige vers la page d'accueil
        if( $user === null ) {
            // header('Location: home'); exit;
            return $this->redirectToRoute('/');
        }
        return $this->render('user_home/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/add", name="add_user")
     * @Route("/admin/edit/{id<\d+>}", name="edit_user")
     */
    public function addUser(
        EntityManagerInterface $objectManager,
        Request $request,
        User $user = null
    ) {
        if( $user === null) {
            $user = new User();
        }
        $form = $this->createForm(UserType::class, $user /*, [
            'validation_groups' => ['Default', $product->getId() ? 'add' : "edit"]
        ]*/); // => App\Form\ProductType
        $form->add('submit', SubmitType::class, [
            'label' => ($user->getId() ? "Editer" : "Ajouter") . " un utilisateur"
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $product->setUser($user);
            $product->setRef(substr(str_shuffle(md5(random_int(0, 1000000))), 0, 25));

            }
            $objectManager->persist($user);
            $objectManager->flush();
            return $this->redirectToRoute('index_home');

        return $this->render('admin_home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
