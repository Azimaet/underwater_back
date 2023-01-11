<?php

namespace App\DataFixtures;

use Exception;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\DivingType;

class DivingTypeFixtures extends Fixture
{
    const ENV_LABELS = [
        'Cave Diving',
        'Ice Diving',
        'Shipwreck Diving',
        'Drift Diving',
        'Rescue',
        'Wildlife Rescue',
        'Reef Cleaning',
        'Nightdiving'
    ];

    const ENV_TOKENS = [
        'cave',
        'ice',
        'wreck',
        'drift',
        'rescue',
        'wildlife',
        'reef',
        'night',
    ];

    const MARKER = '%';

    public function load(ObjectManager $manager): void
    {
        if (count(self::ENV_TOKENS) !== count(self::ENV_LABELS)) {
            throw new Exception('Numbers of Labels and Tokens not identical. Abort persistence of dataFixtures on Database');
        }

        for ($i = 0; $i < count(self::ENV_TOKENS); $i++) {
            $type = new DivingType();
            $label = self::ENV_LABELS[$i];
            $token = self::MARKER . self::ENV_TOKENS[$i] . self::MARKER;

            $type->setLabel($label);
            $type->setToken($token);
            $manager->persist($type);
        }

        $manager->flush();
    }
}
