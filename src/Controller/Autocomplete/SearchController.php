<?php

namespace App\Controller\Autocomplete;

use App\Entity\School;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/autocomplete/search", name="autocomplete_search")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/school", name="school")
     */
    public function school(Request $request)
    {
        // Je récupère la saisi utilisateur envoyé en ajax via jquery ui
        $search = $request->query->get('term');
        // Je fais une recherche en bdd de tout les résultat commençant par cette saisie
        $results = $this->getDoctrine()->getRepository(School::class)->findLike($search);
        // Je déclare un tableau à renvoyer
        $jsonResults = array();
        // Je rempli ce tableau avec le nom de chaque résultat récupéré
        foreach($results as $result)
        {
            $jsonResults[] = $result->getName();
        }
        // je retourne les résultat en format json
        return new JsonResponse($jsonResults);
    }
}
