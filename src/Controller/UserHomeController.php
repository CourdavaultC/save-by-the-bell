<?php

namespace App\Controller;

use App\Entity\Presences;
use App\Entity\User;
use App\Repository\HalfJourneyRepository;
use App\Repository\UserRepository;
use App\Twig\HasPresenceExtension;
use Cassandra\Type\UserType;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserHomeController extends AbstractController
{
    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/user", name="user_home")
     */
    public function index(EntityManagerInterface $manager, HalfJourneyRepository $halfJourneyRepository, UserRepository $userRepository)
    {
        $insertNewPresence = true;
        $user = $this->getUser();
        // 1. récupérer la session de l'utilisateur
        $session = $user->getSession();
        // 2. vérifier qu'elle existe (non nulle)
        if($session === null) {
            $insertNewPresence = false;
            $this->addFlash(
                'notice',
                'La session n\'existe pas'
            );
        }

        // 3. vérifier qu'il existe bien une demi-journée correspondante à demi-journée actuelle
        // dans la session

        // 3.1 récupérer l'heure actuelle
        $heureActuelle = date('H');
        // 3.2 déterminer de fait la periode
        $periodActuelle = ($heureActuelle < 13) ? 'morning' : 'afternoon';
        // 3.3 déterminer la date actuelle
        $dateActuelle = new \DateTime();
        // 3.4 récupérer dans la session la demi journée actuelle
        $halfJourneyActuelle = $halfJourneyRepository->getHalfJourneyBySessionAndByDateAndByPeriod($session, $dateActuelle, $periodActuelle);
        if($halfJourneyActuelle === null) {
            $insertNewPresence = false;
            if ($dateActuelle > $session->getDateEnd()) {
                $this->addFlash(
                    'notice',
                    'La session est terminée'
                );
            } elseif ($dateActuelle < $session->getDateStart()){
                $this->addFlash(
                    'notice',
                    'La session n\'est pas encore commencée'
                );
            } else {
                $this->addFlash(
                    'notice',
                    'Reposez-vous, journée off'
                );
            }

        }
        // 4. vérifier que l'utilisateur n'est pas déjà présent à la demi-journée correspondante
        $presence = null;
        foreach($user->getPresence() as $p) {
            if($p->getHalfJourney() == $halfJourneyActuelle) {
                $presence = $p;
                break;
            }
        }
        if($presence == null && $insertNewPresence) {
        // 5. créer une nouvelle présence pour l'utilisateur et la demi-journée en question
            $presence = new Presences();
            $presence->setUser($user);
            $presence->setHalfJourney($halfJourneyActuelle);
            $presence->setTime($dateActuelle);
            $manager->persist($presence);
            $manager->flush();
            $this->addFlash(
                'notice',
                'Vous avez bien enregistré votre présence'
            );
        } elseif ($presence != null ) {
            $this->addFlash(
                'notice',
                'Vous êtes déjà présent'
            );
        }
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
        if( $user === null) {
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
