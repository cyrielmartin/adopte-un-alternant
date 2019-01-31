<?php
namespace App\Controller\Manager;

use App\Entity\School;

/***
 * Cette classe permet de tester si une école existe en base, et de l'enregistrer si elle n'existe pas.
 * Elle a été créer pour éviter les répétitions dans les méthode add() et edit() des controller Apprenticeship et Formation.
 */
class SchoolManager
{
 /** 
     * Fonction qui récupère le contenu d'une requête et le met à jour si
     * l'école est renseigné, et existe en base ou non.
    */
    public static function checkSchoolData($data, $em)
    {
        // Si le champ School a bien été renseigné
        if(!empty($data['formation']['school']))
        {
            // Je récupère le nom de l'école en virant les espaces
            $schoolName = trim($data['formation']['school']);

            // Si le nom n'est pas vide
            if(!empty($schoolName))
            {
                // je récupère le repository
                $schoolRepo = $em->getRepository(School::class);
                // et cherche si l'école existe
                $schoolExist = $schoolRepo->findOneBy(['name' => $schoolName]);

                // si l'école n'existe pas
                if(empty($schoolExist))
                {
                    // j'appelle la fonction addSchool pour l'ajouter 
                    $newSchool = self::addSchool($schoolName, $em);
                    // je met à jour data avec l'école ajouté en bdd
                    $data['formation']['school'] = $newSchool;

                }
                // si l'école existe
                else
                {
                    // on met à jour data avec l'école déjà présente en bdd
                    $data['formation']['school'] = $schoolExist;
                }
            }
            // Si après trim le champ school était vide data deviens null
            else
            {
                $data = null;
            }
        }
        // Si le champs school n'était pas renseigné data deviens null
        else
        {
            $data = null;
        }

        return $data;
    }

    /** 
     * Méthode permettant d'enregistrer un nouvel établissement de formation
     * en BDD.
     * Prend 1 paramètre : le nom de l'établissement à ajouter
    */
    public static function addSchool($schoolName, $em)
    {
        // je créer un nouvel objet école
        $school = new School();
        // je lui envoi un nom
        $school->setName($schoolName);

        // je l'enregistre en bdd
        $em->persist($school);
        $em->flush($school);
        // je refresh mon objet pour récupèrer l'id enregistré en base
        $em->refresh($school);

        return $school;
    }
}