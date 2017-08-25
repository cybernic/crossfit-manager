<?php

namespace ScheduleBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsRedirectedToLogin($url)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $url);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertContains('/login', $crawler->filter('title')->text());
    }

    public function urlProvider()
    {
        return [
            // DefaultController
            ['/schedule'],
            ['/schedule/events'],

            // EventController
            ['/event/create'],
            ['/event/1'],
            ['/event/1/reserve'],
            ['/event/1/drop'],
            ['/event/1/cancel-reservation'],

            // ProgramController
            ['/program/create'],
            ['/program/edit'],
            ['/program/drop'],
            ['/program/list'],
            ['/program/show'],
        ];
    }
}
