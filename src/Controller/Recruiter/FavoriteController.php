<?php

namespace App\Controller\Recruiter;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/recruteur/favoris", name="favorite_")
 */
class FavoriteController extends AbstractController
{
    /**
     * @Route("/{id}/ajouter", name="add")
     */
    public function add($id)
    {
        /** 
         * Comme le bouton "ajouter aux favoris" se situe dans la page de profil publique d'un candidat, il faudra rediriger 
         * vers celle-ci à l'aide de l'id fourni.
         * 
         * Penser à vérifier que l'id est bien l'id d'un candidat existant avant de faire toute action
         * si id non existant : return $this->redirectToRoute('candidates_list');
         * */ 

        return $this->redirectToRoute('candidates_one', ['id' => $id]);
    }

    /**
     * @Route("/{id}/supprimer", name="delete")
     */
    public function delete()
    {
        /** 
         * Penser à vérifier que l'id est bien l'id d'un candidat existant avant de faire toute action
        */
        return $this->redirectToRoute('recruiter_profile');
    }

    /** 
    * Pas de méthode edit : le recruteur veux (add) ou ne veux pas (delete) un candidat,
    * il n'y a rien à modifier à proprement parler.
    */
}
