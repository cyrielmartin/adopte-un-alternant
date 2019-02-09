<?php

namespace App\Controller\Recruiter;

use App\Entity\IsCandidate;
use App\Entity\IsRecruiter;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RecruiterFavoriteCandidateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/recruteur/favoris", name="favorite_")
 */
class FavoriteController extends AbstractController
{
    /**
     * @Route("/{id}/add", name="add")
     */
    public function add($id, Request $request, EntityManagerInterface $em)
    {
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
      
            $response = ['success'];
        }
        // si le candidat n'existe pas alors
        else
        {
            $response = ['fail', 'Une erreur est survenue'];
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}/delete", name="delete")
     */
    public function delete($id, Request $request, EntityManagerInterface $em)
    {
        /** 
         * Penser à vérifier que l'id est bien l'id d'un candidat existant avant de faire toute action
        */
        $user = $this->getUser();
        $ajax = $request->query->get('ajax');
        $error = false;

        // je récupère sa fiche recruteur
        $recruiterRepo = $em->getRepository(IsRecruiter::class);
        $recruter= $recruiterRepo->findOneBy(['user' => $user->getId()]);

        // je récupère la fiche candidat à ajouter aux favoris
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $id]);
        
        // si le candidat n'existe pas error = true, s'il existe error = false
        $error = empty($candidate)? true : false;

        if(!$error)
        {
            $recruter->removeIsCandidate($candidate);
            $em->persist($recruter);
            $em->flush();
        }

        // s'il n'y a pas eu d'erreur
        if(!$error)
        {
            // si la requête à été faite via ajax
            if($ajax)
            {
                $response = ['success'];
            }
            // si elle a été faite via la page profil du recruteur
            else
            {
                $this->addFlash(
                    'notice',
                    'Ce candidat a bien été supprimé de vos favoris'
                );
            }
        }
        // si il y a eu une erreur
        else
        {
            // si requête faite via ajax
            if($ajax)
            {
                $response = ['fail', 'Une erreur est survenue'];
            }
            // si requête faite via page profil du recruteur
            else
            {
                $this->addFlash('danger', 'Une erreur est survenue');
            }
        }

        if($ajax)
        {
            return new JsonResponse($response);
        }

        return $this->redirectToRoute('recruiter_profile');
    }
}
