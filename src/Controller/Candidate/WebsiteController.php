<?php

namespace App\Controller\Candidate;

use App\Entity\Website;
use App\Entity\VisitCard;
use App\Form\WebsiteType;
use App\Entity\IsCandidate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidat/site", name="website_")
 */
class WebsiteController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add(Request $request)
    {
        
        $user = $this->getUser();
        // je récupère sa fiche candidat
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);
        // récupération de la carte de visite du candidat connecté
        $visitCardRepo = $this->getDoctrine()->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);

        $website= new Website();

        $form = $this->createForm(WebsiteType::class, $website);

        $form->handleRequest($request);

    
        if ($form->isSubmitted() && $form->isValid()) 
        { //dd($request);
            // ajout des info nécessaire à l'enregistrement
            $website = $form->getData();
            
            $website->setVisitCard($visitCard);



            $em = $this->getDoctrine()->getManager();

            // enregistrement en bdd ( par un effet "cascade", le website sera enregistré aussi )
            $em->persist($website);
            $em->flush($website);

            return $this->redirectToRoute('candidate_profile');
        }


        return $this->render('candidate/profile/website.html.twig', [
            'form' => $form->createView(),
            'tab_type' => 'Ajouter',
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit(Request $request, $id, EntityManagerInterface $em)
    {
        $user = $this->getUser();

        // je récupère sa fiche candidat
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);

        // récupération de la carte de visite du candidat connecté
        $visitCardRepo = $em->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);

        // je récupère l'expérience qui doit être mise à jours
        $websiteRepo = $this->getDoctrine()->getRepository(Website::class);
        $website = $websiteRepo->findOneBy(['visitCard' => $visitCard->getId(), 'id' => $id]);

        // si cette expérience appartient bien au candidat connecté
        if(!empty($website))
        {
            $form = $this->createForm(WebsiteType::class, $website);
            $form->handleRequest($request);

        
            if ($form->isSubmitted() && $form->isValid())
            { 
               
            
                // enregistrement en bdd
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Votre site a bien été modifié'
                );
                
                return $this->redirectToRoute('candidate_profile');
            }
        }
        // si cette formation n'appartient pas au user connecté
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue');
            
            return $this->redirectToRoute('candidate_profile');
            
        }
        return $this->render('candidate/profile/website.html.twig', [
            'form'=>$form->createView(),
            'tab_type' => 'Modifier',
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
         //dump($candidate);
         // je récupère la carte de visite du candidat
         $visitCardRepo = $this->getDoctrine()->getRepository(VisitCard::class);
         $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);
         $visitCardId =$visitCard->getId();
         //dump($visitCard);
         //dump($visitCardId);
         // je récupère le site qui doit être supprimé
         $websiteRepo = $this->getDoctrine()->getRepository(Website::class);
         $websiteToDelete = $websiteRepo->findOneBy(['id' => $id, 'visitCard' => $visitCard->getId()]);
        //dd($websiteToDelete);
         
        // si l'experience appartient bien au user alors websiteToDelete n'est pas vide
         if(!empty($websiteToDelete))
         {
             $em = $this->getDoctrine()->getManager();
             // je la supprime
             $em->remove($websiteToDelete);
             $em->flush();
 
             $this->addFlash('notice', 'Votre site a bien été supprimé.');
         }
         else
         {
             $this->addFlash('danger', 'Une erreur est survenue lors de la suppression.');
         }
         
 
        return $this->redirectToRoute('candidate_profile');
    }
}