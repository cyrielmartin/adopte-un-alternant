<?php

namespace App\Controller\Candidate;

use App\Entity\User;
use App\Entity\VisitCard;
use App\Entity\IsCandidate;
use App\Entity\Presentation;
use App\Form\PresentationType;
use App\Form\VisitCardAddType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidat/presentation", name="presentation_")
 */
class PresentationController extends AbstractController
{
    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        // je récupère sa fiche candidat
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $isCandidate = $candidateRepo->findOneBy(['user' => $user->getId()]);
        // je récupère sa carte de visite 
        $visitCardRepo = $this->getDoctrine()->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $isCandidate->getId()]);

        // j'instancie présentation et lui donne les anciennes info du candidat
        $presentation = new Presentation();
        $presentation
            ->setPhoneNumber($isCandidate->getPhoneNumber())
            ->setVisibilityChoice($visitCard->getVisibilityChoice());
        
        $form = $this->createForm(PresentationType::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // je met à jour présentation avec les new valeurs
            $presentation = $form->getData();
            // je met à jour mon objet candidat
            $isCandidate->setPhoneNumber($presentation->getPhoneNumber());
            // je met à jour la carte de visite
            $visitCard->setVisibilityChoice($presentation->getVisibilityChoice());
            // j'envoi le tout en bdd
            $em->flush();
            // je préviens l'utilisateur
            $this->addFlash(
                'notice',
                'La carte de visite a bien été modifiée'
            );
            return $this->redirectToRoute('candidate_profile');
        }

        return $this->render('candidate/profile/presentation.html.twig', [
            'form' => $form->createView(),
        ]);      
    }
}
