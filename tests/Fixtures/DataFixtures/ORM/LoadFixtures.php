<?php

namespace App\Tests\Fixtures\DataFixtures\ORM;

use App\Tests\Fixtures\DataFixtures\Entity\TestUserFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFixtures implements FixtureInterface
{
    use TestUserFixture;

    public function load(ObjectManager $manager)
    {
        $testUser = $this->getTestUserObject();
        $manager->persist($testUser);

        $testUser2 = $this->getTestUserObject();
        $testUser2->setDeletedAt(new \DateTime());
        $manager->persist($testUser2);
    }
}
