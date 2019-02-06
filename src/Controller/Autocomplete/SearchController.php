<?php

namespace App\Controller\Autocomplete;

use App\Entity\School;
use App\Controller\Manager\MobilityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Manager\RecruiterMobilityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/autocomplete/search", name="autocomplete_search_")
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

    /**
     * @Route("/town", name="town")
     */
    public function town(Request $request)
    {
        // Je récupère la saisi utilisateur envoyé en ajax via jquery ui
        $search = $request->query->get('term');
        // je remplace les accens et espaces
        $search = MobilityManager::replaceAccent($search);
        // je prépare mon url
        $apiGeo = 'https://geo.api.gouv.fr/communes?nom='. $search .'&fields=departement&boost=population';
        //var_dump($apiGeo);
        // ouverture de connexion à curl
        $curl = curl_init();
        // je prépare ma connexion
        curl_setopt($curl, CURLOPT_URL, $apiGeo);
        // je précise que je veux récupérer le retour ( Deuxième paramètre : 1 )
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // j'execute ma connexion et récupère le json
        $jsonResponse = curl_exec($curl);
        // je ferme ma connexion 
        curl_close($curl);
        // je décode ce que j'ai récupéré
        $response = json_decode($jsonResponse, true);

        $jsonResults = array();

        // je récupère seulement les nom de 5 villes
        for($i = 0; $i <= 5; $i++)
        {
            // je vérifie si l'index existe au cas ou il y aurais moins de 5 résultats
            if(isset($response[$i]))
            {
                $jsonResults[] = $response[$i]['nom'];
            }
        }

        // je retourne les résultat en format json
        return new JsonResponse($jsonResults);
    }
}
