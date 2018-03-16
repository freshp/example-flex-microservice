<?php

namespace App\Tests\Unit\Route;

use App\Tests\Fixtures\DataFixtures\ORM\LoadFixtures;
use FreshP\PhpunitWebtestcaseFixtureHelper\WebTestCaseWithFixtures;

class RouteTest extends WebTestCaseWithFixtures
{
    public static function setUpBeforeClass()
    {
        self::createClientWithDatabaseAndFixtures(new LoadFixtures());
    }

    public function testPing()
    {
        self::$client->request('GET', '/api/1.0.0/ping');
        $response = self::$client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testList()
    {
        self::$client->request('GET', '/api/1.0.0/list');
        $response = self::$client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAdd()
    {
        self::$client->request(
            'PUT',
            '/api/1.0.0/add',
            ['name' => 'tester']
        );
        $response = self::$client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testShow()
    {
        self::$client->request('GET', '/api/1.0.0/show/1');
        $response = self::$client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdate()
    {
        self::$client->request(
            'POST',
            '/api/1.0.0/update',
            ['name' => 'tester123', 'id' => 1]
        );
        $response = self::$client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRemove()
    {
        self::$client->request('POST', '/api/1.0.0/remove/1');
        $response = self::$client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }
}
