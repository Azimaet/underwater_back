<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@admin.fr');
        $admin->setUsername('Superadmin');
        $admin->setRoles(['ROLE_SUPER_ADMIN']);
        $admin->setSubscribedAt(new \DateTimeImmutable());
        $admin->setActivatedAt(new \DateTimeImmutable());
        $admin->setPassword('$2y$13$WBwnDgO7UPA3Rc6OPrYjK.MY6X207GJu4uZf5l93UloThPa9yPVIq');
        $manager->persist($admin);

        $manager->flush();
    }
}
