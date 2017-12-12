<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Recipe;

/**
 * Recipe controller.
 *
 * @Route("api")
 */
class ApiController extends Controller
{

    /**
     * Lists all recipe entities.
     *
     * @Route("/", name="api_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $recipes = $this->get('serializer')->serialize(
                $em->getRepository('AppBundle:Recipe')->findAll(), 'json', array('groups' => array('list'))
        );

        $response = new Response($recipes);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     *
     * @Route("/post", name="api_post")
     * @Method("POST")
     */
    public function postAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $recipeData = $request->request->get('appbundle_recipe');

        $user = $em->getRepository('AppBundle:User')->find($recipeData['user']);
        $category = $em->getRepository('AppBundle:Category')->find($recipeData['category']);

        $recipe = $em->getRepository('AppBundle:Recipe')->find($recipeData['id']);

        if (count($recipe) == 0) {
            $recipe = new Recipe;
            $recipe->setCreatedAt(new \DateTime());
        }
        $recipe->setUpdatedAt(new \DateTime());
        $recipe->setTitle($recipeData['title']);
        $recipe->setIngredients($recipeData['ingredients']);
        $recipe->setDirections($recipeData['directions']);
        //$recipe->setImage($recipeData['image']);
        $recipe->setRate($recipeData['rate']);
        $recipe->setUser($user);
        $recipe->setCategory($category);
        $isPublic = false;
        if (array_key_exists('isPublic', $recipeData)) {
            $isPublic = $recipeData['isPublic'];
        }
        $recipe->setIsPublic($isPublic);
        $file = $request->files->get('appbundle_recipe');
        var_dump($file);
        if ($file) {
            $upload_dir = $this->getParameter('%kernel.root_dir%').'/../web/images/recipes/'. $recipeData['id'];
            if (!dirname($upload_dir)) {
                mkdir($upload_dir);
            }
            $file_name = $file->getClientOriginalName();
            $file->move($upload_dir, $file_name);
            $recipe->setDocument($file_name);

        }

        $em->merge($recipe);
        $em->flush();

        return $this->redirectToRoute('recipe_index');
    }

    /**
     * Edit recipe entities.
     *
     * @Route("/edit/{id}", name="api_edit")
     * @Method("GET")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('AppBundle:Recipe')->find($id);

        $recipes = $this->get('serializer')->serialize(
                $recipe, 'json', array('groups' => array('edit'))
        );

        $response = new Response($recipes);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Deletes a recipe entity.
     *
     * @Route("/delete/{id}", name="api_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Recipe $recipe)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($recipe);
        $em->flush();

        return $this->redirectToRoute('recipe_index');
    }

}
