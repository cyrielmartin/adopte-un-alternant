<?php

namespace App\Controller\Candidate;

use App\Entity\Website;
use App\Entity\VisitCard;
use App\Form\WebsiteType;
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
        // récupération de la carte de visite du candidat connecté
        $visitCardRepo = $this->getDoctrine()->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['id' => $user->getId()]);

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
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit()
    {
        return $this->render('candidate/profile/website.html.twig', [
            'controller_name' => 'WebsiteController',
        ]);
    }

    /**
     * @Route("/{id}/supprimer", name="delete")
     */
    public function delete()
    {
        return $this->redirectToRoute('candidate_profile');
    }
}