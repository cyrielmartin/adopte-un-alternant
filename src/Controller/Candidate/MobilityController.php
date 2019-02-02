<?php

namespace App\Controller\Candidate;

use App\Entity\Mobility;
use App\Entity\VisitCard;
use App\Entity\IsCandidate;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidat/localisation", name="mobility_")
 */
class MobilityController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add()
    {
        return $this->render('candidate/profile/mobility.html.twig', [
            'controller_name' => 'MobilityController',
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit()
    {
        return $this->render('candidate/profile/mobility.html.twig', [
            'controller_name' => 'MobilityController',
        ]);
    }

    /**
     * @Route("/{id}/supprimer", name="delete")
     */
    public function delete($id)
    {
        // je récupère le user
        $user = $this->getUser();
        // je récupère sa fiche candidat
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);
        // je récupère sa carte de visite 
        $visitCardRepo = $this->getDoctrine()->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);
        // je récupère la mobilité via sont id
        $mobilityRepo = $this->getDoctrine()->getRepository(Mobility::class);
        $mobility = $mobilityRepo->find($id);
        
        // si cette mobilité existe
        if(!empty($mobility))
        {
            // je supprime la relation avec celle-ci de la carte de visite du candidat
            $visitCard->removeMobility($mobility);

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'La ville a bien été supprimée.');
        }
        // si la mobilité n'existe pas
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue lors de la suppression.');
        }
        
        return $this->redirectToRoute('candidate_profile');
    }
}