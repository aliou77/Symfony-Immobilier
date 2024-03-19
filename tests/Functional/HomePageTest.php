<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePageTest extends WebTestCase
{
    // test the homepage loading
    public function testHomePageLayout(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Modern Asset In Town');
        $this->assertSelectorTextContains('a.transition-all.duration-300', 'Explore More');
    }
}
