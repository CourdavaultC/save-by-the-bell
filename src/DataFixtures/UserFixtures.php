<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class UserFixtures extends Fixture
{
    const NB_USERS = 20;
    const NB_ADMINS = 3;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        for ($i=0; $i<self::NB_ADMINS; $i++) {
            $user = new User();
            $user->setLastname("nomadmin$i");
            $user->setFirstname("prénomadmin$i");
            $user->setEmail("emailadmin$i@mail.com");
            $user->setPassword($this->encoder->encodePassword($user, "password$i"));
            $user->setRoles(["ROLE_ADMIN"]);
            $this->addReference("admin$i", $user);

            $manager->persist($user);
        }

        for ($i=0; $i<self::NB_USERS; $i++) {
           $user = new User();
           $user->setLastname("nom$i");
           $user->setFirstname("prénom$i");
           $user->setEmail("email$i@mail.com");
           $user->setPassword($this->encoder->encodePassword($user, "password$i"));
           $user->setRoles(["ROLE_USER"]);
           $this->addReference("user$i", $user);

           $manager->persist($user);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
