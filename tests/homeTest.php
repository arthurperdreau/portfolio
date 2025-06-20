<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class homeTest extends WebTestCase
{
    public function testHomePageLoadsCorrectly(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'My projects');
        $this->assertSelectorTextContains('h2', 'Contact me');
        $this->assertSelectorExists('form[name="contact_form"]');
    }

    public function testSubmitContactFormSuccessfully(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $form = $crawler->filter('form[name="contact_form"]')->form([
            'contact_form[name]' => 'Jean Test',
            'contact_form[email]' => 'test@example.com',
            'contact_form[message]' => 'Ceci est un test fonctionnel.'
        ]);

        $client->submit($form);

        $client->followRedirect();
        $this->assertSelectorExists('.bg-green-500');
        $this->assertSelectorTextContains('.bg-green-500', 'Your message has been sent!');
    }
}

