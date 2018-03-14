<?php

namespace App\Tests\Fixtures\DataFixtures\Entity;

use App\Entity\TestUser;

trait TestUserFixture
{
    protected $username = 'test@test.de';

    protected function getTestUserObject(): TestUser
    {
        return new TestUser($this->username);
    }
}
