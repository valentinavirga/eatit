<?php

namespace AppBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use AppBundle\Entity\Recipe;

class ApiControllerTest extends WebTestCase
{

    protected function setUp()
    {
        $this->fixtures = $this->loadFixtures(array(
                    'AppBundle\DataFixtures\ORM\LoadCategoryData',
                    'AppBundle\DataFixtures\ORM\LoadUserData',
                    'AppBundle\DataFixtures\ORM\LoadRecipesData',
                ))->getReferenceRepository();
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);

        $recipe = $responseData[0];

        $this->assertCount(2, $responseData);
        $this->assertEquals("Pasta", $recipe['title']);
        $this->assertEquals("Pasta, pomodoro, cipolla", $recipe['ingredients']);
        $this->assertEquals("Cuocere la pasta e mettere il sugo di pomodoro e cipolla", $recipe['directions']);
    }

    public function testEdit()
    {
        $recipeId = $this->fixtures->getReference('recipe.pasta')->getId();

        $client = static::createClient();
        $recipe = new Recipe();

        $crawler = $client->request('GET', '/api/edit/' . $recipeId);

        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals("Pasta", $responseData['title']);
        $this->assertEquals("Pasta, pomodoro, cipolla", $responseData['ingredients']);
        $this->assertEquals("Cuocere la pasta e mettere il sugo di pomodoro e cipolla", $responseData['directions']);
    }

    public function testPost()
    {
        $recipeData = [];
        $recipe = $this->fixtures->getReference('recipe.pasta');

        $recipeData['id'] = $recipe->getId();
        $recipeData['user'] = $recipe->getUser()->getId();
        $recipeData['category'] = $recipe->getCategory()->getId();
        $recipeData['title'] = $recipe->getTitle();
        $recipeData['ingredients'] = $recipe->getIngredients();
        $recipeData['directions'] = $recipe->getDirections();
        $recipeData['image'] = $recipe->getImage();
        $recipeData['rate'] = $recipe->getRate();
        $recipeData['isPublic'] = $recipe->getIsPublic();

        $client = static::createClient();

        $crawler = $client->request('POST', '/api/post', ['appbundle_recipe' => $recipeData]);
        $response = $client->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testNewPost()
    {
        $user = $this->fixtures->getReference('utente.prova');
        $category = $this->fixtures->getReference('category.pasta');

        $recipe = ['id' => '14',
            'title' => 'edit recipe 2',
            'ingredients' => 'Pasta, pomodoro, cipolla',
            'directions' => 'Cuocere la pasta e mettere il sugo di pomodoro e cipolla',
            'image' => 'pasta.jpg',
            'rate' => '4',
            'isPublic' => true,
            'user' => $user->getId(),
            'category' => $category->getId()
        ];

        $client = static::createClient();

        $crawler = $client->request('POST', '/api/post', ['appbundle_recipe' => $recipe]);
        $response = $client->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
    }

}
