<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Recipe;

class LoadRecipesData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $em)
    {
        $pasta = new Recipe();
        $pasta->setCategory($em->merge($this->getReference('category.pasta')));
        $pasta->setUser($em->merge($this->getReference('utente.prova')));
        $pasta->setTitle('Pasta');
        $pasta->setIngredients('Pasta, pomodoro, cipolla');
        $pasta->setDirections('Cuocere la pasta e mettere il sugo di pomodoro e cipolla');
        $pasta->setImage('pasta.jpg');
        $pasta->setRate(4);
        $pasta->setIsPublic(true);
        $pasta->setCreatedAt(new \DateTime('2017-10-10'));
        $pasta->setUpdatedAt(new \DateTime('2017-10-10'));
        $em->persist($pasta);
        
        $dessert = new Recipe();
        $dessert->setCategory($em->merge($this->getReference('category.dessert')));
        $dessert->setUser($em->merge($this->getReference('utente.prova')));
        $dessert->setTitle('Dessert');
        $dessert->setIngredients('cioccolato, farina, zucchero');
        $dessert->setDirections('Mischiare tutto e infornare');
        $dessert->setImage('dessert.jpg');
        $dessert->setRate(4);
        $dessert->setIsPublic(true);
        $dessert->setCreatedAt(new \DateTime('2017-10-10'));
        $dessert->setUpdatedAt(new \DateTime('2017-10-10'));
        $em->persist($dessert);

        $em->flush();
        $this->addReference('recipe.pasta', $pasta);
        $this->addReference('recipe.dessert', $dessert);

    }

    public function getOrder()
    {
        return 10; 
    }

}
