<?php

namespace App\Tests\Functional\Controller;

use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ColleagueControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Colleagues', $client->getResponse()->getContent());
        $this->assertStringContainsString('Id', $client->getResponse()->getContent());
        $this->assertStringContainsString('Name', $client->getResponse()->getContent());
        $this->assertStringContainsString('Email', $client->getResponse()->getContent());
        $this->assertStringContainsString('Picture', $client->getResponse()->getContent());
        $this->assertStringContainsString('Note', $client->getResponse()->getContent());
    }
}
