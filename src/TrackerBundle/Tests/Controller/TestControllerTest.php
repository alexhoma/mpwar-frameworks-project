<?php

namespace TrackerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/home');
    }

    public function testBlog()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/blog');
    }

    public function testFaq()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/faq');
    }

}
