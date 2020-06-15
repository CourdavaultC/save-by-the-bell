<?php

namespace App\DataFixtures;

use App\Entity\HalfJourney;
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
            $date=$dateStart;
            while ($date<$dateEnd) {
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

                $manager->persist($half_journey_morning);
                $manager->persist($half_journey_afternoon);
            }

            $manager->persist($session);
        }

        $manager->flush();
    }

}
