<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $em)
    {
        $appetizer = new Category();
        $appetizer->setName('Appetizer');
        $em->persist($appetizer);
        
        $breakfast = new Category();
        $breakfast->setName('Breakfast');
        $em->persist($breakfast);
        
        $dessert = new Category();
        $dessert->setName('Dessert');
        $em->persist($dessert);
        
        $breads = new Category();
        $breads->setName('Breads');
        $em->persist($breads);
        
        $salads = new Category();
        $salads->setName('Salads');
        $em->persist($salads);
        
        $pasta = new Category();
        $pasta->setName('Pasta');
        $em->persist($pasta);
    
        $this->addReference('category.pasta', $pasta);
        $this->addReference('category.dessert', $dessert);

        $em->flush();

    }

    public function getOrder()
    {
        return 1; 
    }

}
