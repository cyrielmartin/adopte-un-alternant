<?php

namespace App\Controller\Recruiter;

use App\Entity\IsCandidate;
use App\Entity\IsRecruiter;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RecruiterFavoriteCandidateType;
use Symfony\Component\HttpFoundation\Request;
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
    public function add($id, Request $request, EntityManagerInterface $em)
    {
        /** 
         * Comme le bouton "ajouter aux favoris" se situe dans la page de profil publique d'un candidat, il faudra rediriger 
         * vers celle-ci à l'aide de l'id fourni.
         * 
         * Penser à vérifier que l'id est bien l'id d'un candidat existant avant de faire toute action
         * si id non existant : return $this->redirectToRoute('candidates_list');
         * */ 
        dump($id);

        $user = $this->getUser();
        
        dump($user);
        // je récupère sa fiche recruteur
        $recruiterRepo = $em->getRepository(IsRecruiter::class);
        $recruteur= $recruiterRepo->findOneBy(['user' => $user->getId()]);
        
        //dd($recruteur);

        //$favoriteCandidate = new IsRecruiter();

        $form = $this->createForm(RecruiterFavoriteCandidateType::class, $recruteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            //$favoriteCandidate = $form->getData();
            //dd($favoriteCandidate);

            // je vérifie que la ville existe
            //$town = MobilityManager::isRealTown($mobility);
            
            // si la clef fail existe, l'api n'a renvoyé aucun résultat
            // c'est donc un message d'erreur qui a été retourné
            //if(isset($town['fail']))
            //{
            //    $this->addFlash('danger', $town['fail']);
            //    return $this->redirectToRoute('mobility_add');
            //}
            //// sinon l'api a renvoyé un résultat
            //// $town['success'] contient le tableau de réponse renvoyé par l'api
            //$mobility = MobilityManager::recoverMobility($town, $em);
            // je lie ma mobilité et ma carte de viste 
            $recruter->addIsCandidate($id);
            $em->persist($recruter);
            $em->flush();
        }

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
