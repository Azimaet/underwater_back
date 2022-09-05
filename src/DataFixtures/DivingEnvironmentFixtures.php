<?php

namespace App\DataFixtures;

use App\Entity\DivingEnvironment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class DivingEnvironmentFixtures extends Fixture
{
    const ENV_LABELS = ['Pool', 'Sea', 'River or Lake'];
    
    const ENV_TOKENS = ['pool', 'sea', 'lake'];

    const MARKER = '%';

    public function load(ObjectManager $manager): void
    {
        if (count(self::ENV_TOKENS) !== count(self::ENV_LABELS)){
            throw new Exception('Numbers of Labels and Tokens not identical. Abort persistence of dataFixtures on Database');
        }

        for ($i = 0; $i < count(self::ENV_TOKENS); $i++) {
            $env = new DivingEnvironment();
            $label = self::ENV_LABELS[$i];
            $token = self::MARKER . self::ENV_TOKENS[$i] . self::MARKER;

            $env->setLabel($label);
            $env->setToken($token);
            $manager->persist($env);
        }

        $manager->flush();
    }
}
