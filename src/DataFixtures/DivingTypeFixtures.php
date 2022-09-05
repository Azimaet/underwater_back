<?php

namespace App\DataFixtures;

use App\Entity\DivingType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class DivingTypeFixtures extends Fixture
{
    const ENV_LABELS = [
        'Dive', 
        'Cave Diving', 
        'Ice Diving', 
        'Shipwreck Diving', 
        'Drift Diving',
        'Rescue',
        'Wildlife Rescue',
        'Reef Cleaning',
        'Technical and Operations',
        'Nightdiving'
    ];
    
    const ENV_TOKENS = [
        'default', 
        'cave', 
        'ice', 
        'wreck', 
        'drift',
        'rescue',
        'wildlife',
        'reef',
        'technical',
        'night',
    ];

    const MARKER = '%';

    public function load(ObjectManager $manager): void
    {
        if (count(self::ENV_TOKENS) !== count(self::ENV_LABELS)){
            throw new Exception('Numbers of Labels and Tokens not identical. Abort persistence of dataFixtures on Database');
        }
        
        for ($i = 0; $i < count(self::ENV_TOKENS); $i++) {
            $role = new DivingType();
            $label = self::ENV_LABELS[$i];
            $token = self::MARKER . self::ENV_TOKENS[$i] . self::MARKER;

            $role->setLabel($label);
            $role->setToken($token);
            $manager->persist($role);
        }

        $manager->flush();
    }
}
