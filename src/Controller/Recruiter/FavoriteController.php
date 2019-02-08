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
        

        $user = $this->getUser();
        
       
        // je récupère sa fiche recruteur
        $recruiterRepo = $em->getRepository(IsRecruiter::class);
        $recruter= $recruiterRepo->findOneBy(['user' => $user->getId()]);

        // je récupère la fiche candidat à ajouter aux favoris
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $id]);
        
        //si le candidate existe alors
        if(!empty($candidate))
        {
            $recruter->addIsCandidate($candidate);
            $em->persist($recruter);
            $em->flush();

            $this->addFlash(
                'notice',
                'Ce candidat a bien été ajouté à vos favoris'
            );
      

        return $this->redirectToRoute('candidates_list');
        }

        // si le candidat n'existe pas alors
        else
        {
            $this->addFlash(
                'danger',
                'Une erreur est survenue'
            );
            return $this->redirectToRoute('candidates_list');
        }
            
    }

    /**
     * @Route("/{id}/supprimer", name="delete")
     */
    public function delete($id, Request $request, EntityManagerInterface $em)
    {
        /** 
         * Penser à vérifier que l'id est bien l'id d'un candidat existant avant de faire toute action
        */
        $user = $this->getUser();
        
       
        // je récupère sa fiche recruteur
        $recruiterRepo = $em->getRepository(IsRecruiter::class);
        $recruter= $recruiterRepo->findOneBy(['user' => $user->getId()]);

        // je récupère la fiche candidat à ajouter aux favoris
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $id]);
        
        //si le candidate existe alors
        if(!empty($candidate)){
            $recruter->removeIsCandidate($candidate);
            $em->persist($recruter);
            $em->flush();

            $this->addFlash(
                'notice',
                'Ce candidat a bien été supprimé de vos favoris'
            );
      

            return $this->redirectToRoute('recruiter_profile');
        }
        // si le candidat n'existe pas alors
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue');
            return $this->redirectToRoute('recruiter_profile');
        }
            
    }


    /** 
    * Pas de méthode edit : le recruteur veut (add) ou ne veut pas (delete) un candidat,
    * il n'y a rien à modifier à proprement parler.
    */
}
