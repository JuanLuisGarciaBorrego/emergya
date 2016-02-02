<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TablonControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Tablón Emergya', $crawler->filter('h1')->text());
    }

    public function testNewMessage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/crear-mensaje');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $buttonCrawler = $crawler->selectButton('Enviar mensaje')->form();

        $buttonCrawler['user[nick]'] = rand(0, 100)."usernick";
        $buttonCrawler['user[message]'] = 'Descripción de prueba';

        $client->submit($buttonCrawler);
        $this->assertEquals(200, $client->getResponse()->isRedirect());
        $client->followRedirect();
    }
}
