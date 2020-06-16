<?php

namespace App\Twig;

use App\Entity\HalfJourney;
use App\Entity\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class HasPresenceExtension extends AbstractExtension
{


    public function getFunctions(): array
    {
        return [
            new TwigFunction('has_presence', [$this, 'hasPresence']),
        ];
    }

    public function hasPresence(User $user, HalfJourney $halfJourney)
    {
        foreach($user->getPresence() as $presence) {
            if ($presence->getHalfJourney()===$halfJourney) {
                return true;
            }
        }
        return false;
    }
}
