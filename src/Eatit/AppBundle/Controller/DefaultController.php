<?php

namespace Eatit\AppBundle\Controller;

use AppBundle\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Recipe controller.
 *
 */
class DefaultController extends Controller
{

    /**
     * Lists all recipe entities.
     *
     * @Route("/", name="index")
     * @Method("GET")
     * @Template
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $recipes = $em->getRepository('AppBundle:Recipe')->findAll();
        //brutto, solo per agganciare i widget al modale

        return array(
            'recipes' => $recipes,
        );
    }

}
