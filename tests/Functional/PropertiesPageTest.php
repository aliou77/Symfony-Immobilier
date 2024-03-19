<?php

namespace App\Tests\Functional;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PropertiesPageTest extends WebTestCase
{
    public function testPropertiesPageLayout(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/properties');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('button.btn-search', 'Search');
    }

    public function testPropertiesShowPageLayout(): void{
        $client = static::createClient();
        $client->request('GET', '/properties/premier-bien-201');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'premier bien');
    }
}
