<?php

namespace App\Controller\Candidate;

use App\Entity\VisitCard;
use App\Form\AdoptedType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidat/adopte", name="adopted_")
 */
class AdoptedController extends AbstractController
{
    /**
    * @Route("/{id}/modifier", name="edit")
    */
   public function edit(VisitCard $visitCard, Request $request, EntityManagerInterface $em)
   {
       $adoptedForm = $this->createForm(AdoptedType::class, $visitCard);
       $adoptedForm->handleRequest($request);
       if ($adoptedForm->isSubmitted() && $adoptedForm->isValid()) {
           $em->persist($visitCard);
           $em->flush();
           
           $this->addFlash(
               'notice',
               'Votre présentation a bien été modifiée'
           );
           return $this->redirectToRoute('candidate_profile');
       }
       return $this->render('candidate/profile/adopted.html.twig', [
           'adoptedForm' => $adoptedForm->createView(),
       ]);
   }
   
}
