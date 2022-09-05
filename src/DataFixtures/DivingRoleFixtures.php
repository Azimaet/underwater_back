<?php

namespace App\DataFixtures;

use App\Entity\DivingRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class DivingRoleFixtures extends Fixture
{
    const ENV_LABELS = ['Exploring', 'Learning', 'Guiding', 'Teaching', 'Professional'];
    
    const ENV_TOKENS = ['explore', 'learn', 'guide', 'teach', 'professional'];

    const MARKER = '%';

    public function load(ObjectManager $manager): void
    {
        if (count(self::ENV_TOKENS) !== count(self::ENV_LABELS)){
            throw new Exception('Numbers of Labels and Tokens not identical. Abort persistence of dataFixtures on Database');
        }
        
        for ($i = 0; $i < count(self::ENV_TOKENS); $i++) {
            $role = new DivingRole();
            $label = self::ENV_LABELS[$i];
            $token = self::MARKER . self::ENV_TOKENS[$i] . self::MARKER;

            $role->setLabel($label);
            $role->setToken($token);
            $manager->persist($role);
        }

        $manager->flush();
    }
}
