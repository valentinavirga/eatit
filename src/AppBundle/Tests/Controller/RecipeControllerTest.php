<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeControllerTest extends WebTestCase
{
    
    public function testCompleteScenario()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/recipe/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /recipe/");
        
//        $this->assertEquals("Recipes list", $crawler->filter('h1')->text());
    }

}
