<?php

namespace App\Controller\Candidate;

use App\Entity\User;
use App\Entity\IsCandidate;
use App\Form\VisitCardType;
use App\Form\IsCandidateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\VisitCard;

/**
 * @Route("/candidat/presentation", name="about_")
 */
class AboutController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add()
    {
        return $this->render('candidate/profil/about.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }

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
                'La page de présentation a bien été modifiée'
            );
            return $this->redirectToRoute('about_edit', ['id' => $user->getId()]);
        }

        $visitCardForm = $this->createForm(VisitCardType::class, $visitCard);
        $visitCardForm->handleRequest($request);
        if ($visitCardForm->isSubmitted() && $visitCardForm->isValid()) {
            $em->persist($visitCard);
            $em->flush();

            $this->addFlash(
                'notice',
                'La page de présentation a bien été modifiée'
            );
            return $this->redirectToRoute('about_edit', ['id' => $user->getId()]);
        }

        return $this->render('candidate/profil/about.html.twig', [
            'isCandidateForm' => $isCandidateForm->createView(),
            'visitCardForm' => $visitCardForm->createView(),
        ]);      
    }

    /**
     * @Route("/{id}/supprimer", name="delete")
     */
    public function delete()
    {
        return $this->redirectToRoute('candidate_profil');
    }
}
