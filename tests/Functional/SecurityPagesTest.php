<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityPageTest extends WebTestCase
{
    public function testLoginPageLayout(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Please sign in to access the Back Office');
    }

    // public function testAdminPageLayout(): void
    // {
    //     $client = static::createClient();
    //     $crawler = $client->request('GET', '/admin');

    //     // $this->assertResponseIsSuccessful();
    //     $this->assertResponseStatusCodeSame('302');
    //     $this->assertSelectorTextContains('h1', 'Welcome to the Helter Administration');
    // }
}
