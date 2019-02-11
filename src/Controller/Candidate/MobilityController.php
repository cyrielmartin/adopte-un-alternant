<?php

namespace App\Controller\Candidate;

use App\Entity\Mobility;
use App\Entity\VisitCard;
use App\Entity\Department;
use App\Form\MobilityType;
use App\Entity\IsCandidate;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Manager\MobilityManager;
use Symfony\Component\HttpFoundation\Request;
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
    public function add(Request $request, EntityManagerInterface $em)
    {
        // je récupère le user
        $user = $this->getUser();
        // je récupère sa fiche candidat
        $candidateRepo = $em->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);
        // je récupère la carte de visite du candidat
        $visitCardRepo = $em->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);
        // je compte le nombre de ville enregistré
        $maxMob = $visitCard->getMobilities()->count();
        // s'il en a 3 ou plus
        if ($maxMob >= 3)
        {
            $this->addFlash('warning', 'Vous ne pouvez pas avoir plus de 3 villes');
            return $this->redirectToRoute('candidate_profile');
        }

        $mobility = new Mobility();

        $form = $this->createForm(MobilityType::class, $mobility);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $mobility = $form->getData();
            // je vérifie que la ville existe
            $town = MobilityManager::isRealTown($mobility);
            // si la clef fail existe, l'api n'a renvoyé aucun résultat
            // c'est donc un message d'erreur qui a été retourné
            if(isset($town['fail']))
            {
                $this->addFlash('danger', $town['fail']);
                return $this->redirectToRoute('mobility_add');
            }
            // sinon l'api a renvoyé un résultat
            // $town['success'] contient le tableau de réponse renvoyé par l'api
            $mobility = MobilityManager::recoverMobility($town, $em);
            // je lie ma mobilité et ma carte de viste 
            $visitCard->addMobility($mobility);
            $em->persist($visitCard);
            $em->flush();

            return $this->redirectToRoute('candidate_profile');
        }
        return $this->render('candidate/profile/mobility.html.twig', [
            'tab_type' => 'Ajouter',
            'form' => $form->createView(),
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
            $this->addFlash('notice', 'La ville a bien été supprimée.');
        }
        // si la mobilité n'existe pas
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue lors de la suppression.');
        }
        
        return $this->redirectToRoute('candidate_profile');
    }
}