<?php
namespace App\Controller\Manager;

use App\Entity\Mobility;
use App\Entity\Department;


/***
 * Cette classe permet de tester si une ville existe grâce à ApiGeo, 
 * Si elle existe, est-ce qu'elle est déjà présente en base ? --> l'enregistrer si ça n'est pas le cas.
 * Elle a été créé pour éviter les répétitions dans les méthodes add() et edit() du controller mobility
 */
class MobilityManager
{
    /** 
     * Cette méthode permet de vérifier si un ville existe et de récupérer 
     * un tableau d'information sur la ville en question
     * */ 
    public static function isRealTown($mobility)
    {
        // je récupère le nom de la ville donnée par le candidat
        $townName = $mobility->getTownName();
        // je remplace tout les accents et caractère particulier potentiel
        $townName = self::replaceAccent($townName);
        // je prépare mon url
        $apiGeo = 'https://geo.api.gouv.fr/communes?nom='. $townName .'&fields=departement&boost=population';
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

        // si la réponse est vide : la ville n'existe pas
        if (empty($response)) 
        {
            return ['fail' => 'Ville introuvable ou inexistante'];
        }
        // si il y a plus d'une réponse : la ville a été partiellement renseignée
        else if(count($response) > 1)
        {
            return $response[0];
        }
        
        return $response[0];
    }

    /** 
     * Cette méthode permet de remplacer les espaces par des tiret ainsi que 
     * tout les types d'accent et de caractère tel que ç,ø... dans une chaîne 
     * de caractère donnée.
    */
    public static function replaceAccent($str)
    {
        // transformer les caractères accentués en entités HTML
        $str = htmlentities($str, ENT_NOQUOTES, 'utf-8');
     
        // remplacer les entités HTML pour avoir juste le premier caractères non accentués
        // Exemple : "&ecute;" => "e", "&Ecute;" => "E", "à" => "a" ...
        $str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);
     
        // Remplacer les ligatures
        // Exemple "œ" => "oe"
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        // Supprimer tout le reste
        $str = preg_replace('#&[^;]+;#', '', $str);
        // je remplace aussi les espaces par des tirets
        $str = str_replace(' ', '-', $str);
     
        return $str;
    }

    /** 
     * Cette méthode vérifie si la ville entré par le candidat est déjà
     * enregistré en base de donnée, si oui elle retourne l'objet mobility
     * sinon elle créer un objet mobility l'ajoute en base et le retourne.
     * 
     * ATTENTION : cette méthode est basé sur la structure du tableau 
     * renvoyé par l'API géo dans la méthode isRealTown().
    */
    public static function recoverMobility($town, $em)
    {
        // je récupère le nom de la ville
        $townName = $town['nom'];
        
        // je récupère la ville en bdd
        $mobilityRepo = $em->getRepository(Mobility::class);
        $mobilityExist = $mobilityRepo->findOneBy(['townName' => $townName]);

        // si la ville existe en bdd
        if(!empty($mobilityExist))
        {
            $mobility = $mobilityExist;
        }
        // si la ville n'existe pas en bdd
        else
        {
            // je créer l'objet et lui envoi le nom de la ville
            $mobility = new Mobility();
            $mobility->setTownName($townName);
            
            // je récupère son code de département
            $dptCode = $town['departement']['code'];
            // je récupère l'objet département associé à ce code en base
            $dptRepo = $em->getRepository(Department::class);
            $department = $dptRepo->findOneBy(['code' => $dptCode]);
            // je relie ma ville et son département
            $mobility->setDepartment($department);
            $em->persist($mobility);
            // j'enregistre en base
            $em->flush($mobility);
            // je met à jour mon objet avec l'id de la ville nouvellement crée
            $em->refresh($mobility);
        }
        // dans tout les cas je retourne un objet mobility
        return $mobility;
    }
}