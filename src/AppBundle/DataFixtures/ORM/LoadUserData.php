<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $em)
    {
        $utente = new User();
        $utente->setNickname('utente prova');
        $utente->setLastname('prova');
        $utente->setEmail('prova');
        $utente->setUsername('prova');
        $utente->setPassword('prova');
        $utente->setFirstname('utente prova');
        $utente->setImage('prova.jpg');
        $em->persist($utente);
        
        $this->addReference('utente.prova', $utente);

        $em->flush();

    }

    public function getOrder()
    {
        return 1; 
    }

}
