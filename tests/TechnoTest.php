<?php

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TechnoTest extends WebTestCase
{
    public function testDisplayTechnoForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/techno/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    public function testSubmitValidTechnoForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/techno/new');

        $form = $crawler->selectButton('Submit')->form([
            'techno_form[name]' => 'Symfony',
        ]);

        $client->submit($form);

        $this->assertResponseRedirects('/');
        $client->followRedirect();
        $this->assertSelectorExists('body');
    }
}
