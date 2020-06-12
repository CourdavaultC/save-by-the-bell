<?php

namespace App\DataFixtures;

use App\Entity\Session;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SessionFixtures extends Fixture
{
    const NB_SESSION = 3;
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i<self::NB_SESSION; $i++) {
            $session = new Session();
            $session->setName("Ma session $i");
            $now = new \DateTimeImmutable();
            $dateStart = $now->sub(\DateInterval::createFromDateString("$i months"));
            $session->setDateStart($dateStart);
            $dateEnd = $dateStart->add(\DateInterval::createFromDateString("3 months"));
            $session->setDateEnd($dateEnd);
            $this->addReference("Session $i", $session);

            $manager->persist($session);
        }

        $manager->flush();
    }

}
