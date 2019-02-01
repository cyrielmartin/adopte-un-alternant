<?php

namespace App\Controller\Candidate;

use App\Entity\User;
use App\Entity\VisitCard;
use App\Entity\IsCandidate;
use App\Form\VisitCardType;
use App\Form\IsCandidateType;
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
    public function edit(User $user, IsCandidate $isCandidate, VisitCard $visitCard, Request $request, EntityManagerInterface $em)
    {
        $isCandidateForm = $this->createForm(IsCandidateType::class, $isCandidate);
        $isCandidateForm->handleRequest($request);
        if ($isCandidateForm->isSubmitted() && $isCandidateForm->isValid()) {
            $em->persist($isCandidate);
            $em->flush();
            
            $this->addFlash(
                'notice',
                'La carte de visite a bien été modifiée'
            );
            return $this->redirectToRoute('presentation', ['id' => 2]);
        }

        $visitCardForm = $this->createForm(VisitCardType::class, $visitCard);
        $visitCardForm->handleRequest($request);
        if ($visitCardForm->isSubmitted() && $visitCardForm->isValid()) {
            $em->persist($visitCard);
            $em->flush();

            $this->addFlash(
                'notice',
                'La carte de visite a bien été modifiée'
            );
            return $this->redirectToRoute('candidate_profile');
        }

        return $this->render('candidate/profile/presentation.html.twig', [
            'isCandidateForm' => $isCandidateForm->createView(),
            'visitCardForm' => $visitCardForm->createView(),
        ]);      
    }
}
