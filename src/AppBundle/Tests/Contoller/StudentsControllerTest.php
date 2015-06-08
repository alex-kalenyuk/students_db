<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

class StudentsControllerTest extends WebTestCase
{
    const FIFTEEN_MIN_IN_SEC = 900;
    /**
     * @var Client
     */
    public $client;
    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testDetailActionCheckCache()
    {
        $this->client->request('GET', '/students/detail/firstname_lastname');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        echo $this->client->getResponse()->getContent();
        $this->assertEquals(self::FIFTEEN_MIN_IN_SEC, $this->client->getResponse()->getMaxAge());
        $this->assertEquals(new \DateTime('15 minutes'), $this->client->getResponse()->getExpires());
    }

    public function testDetailActionCheckUniquePath()
    {
        $this->client->request('GET', '/students/detail/firstname_lastname_1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
