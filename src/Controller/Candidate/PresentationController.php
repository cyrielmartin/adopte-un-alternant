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
     * @Route("/ajouter", name="add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        // $isCandidate = new IsCandidate();
        // $isCandidateForm = $this->createForm(IsCandidateType::class, $isCandidate);
        // $isCandidateForm->handleRequest($request);

        // if ($isCandidateForm->isSubmitted() && $isCandidateForm->isValid()) {
        //     $em->persist($isCandidate);
        //     $em->flush();

        //     $this->addFlash(
        //         'notice',
        //         'Les informations ont bien été enregistrées'
        //     );
            
        //     return $this->redirectToRoute('candidate_profil');
        // }

        $visitCardAdd = new VisitCard();
        $visitCardAddForm = $this->createForm(VisitCardAddType::class, $visitCardAdd);
        $visitCardAddForm->handleRequest($request);

        if ($visitCardAddForm->isSubmitted() && $visitCardAddForm->isValid()) {
            $visitCardAdd->setAdopted(0);
            $em->persist($visitCardAdd);
            $em->flush();

            $this->addFlash(
                'notice',
                'Les informations ont bien été enregistrées'
            );
            
            return $this->redirectToRoute('candidate_profil');
        }


        return $this->render('candidate/profile/presentation_add.html.twig', [
            // 'isCandidateForm' => $isCandidateForm->createView(),
            'visitCardAddForm' => $visitCardAddForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit(User $user, IsCandidate $isCandidate, VisitCard $visitCard, Request $request, EntityManagerInterface $em)
    {
        // $isCandidateForm = $this->createForm(IsCandidateType::class, $isCandidate);
        // $isCandidateForm->handleRequest($request);
        // if ($isCandidateForm->isSubmitted() && $isCandidateForm->isValid()) {
        //     $em->persist($isCandidate);
        //     $em->flush();
            
        //     $this->addFlash(
        //         'notice',
        //         'La page de présentation a bien été modifiée'
        //     );
        //     return $this->redirectToRoute('presentation_edit', ['id' => $user->getId()]);
        // }

        $visitCardForm = $this->createForm(VisitCardType::class, $visitCard);
        $visitCardForm->handleRequest($request);
        if ($visitCardForm->isSubmitted() && $visitCardForm->isValid()) {
            $em->persist($visitCard);
            $em->flush();

            $this->addFlash(
                'notice',
                'La page de présentation a bien été modifiée'
            );
            return $this->redirectToRoute('presentation_edit', ['id' => $user->getId()]);
        }

        return $this->render('candidate/profile/presentation_edit.html.twig', [
            // 'isCandidateForm' => $isCandidateForm->createView(),
            'visitCardForm' => $visitCardForm->createView(),
        ]);      
    }

    /**
     * @Route("/{id}/supprimer", name="delete")
     */
    public function delete(IsCandidate $isCandidate, VisitCard $visitCard, EntityManagerInterface $em)
    {
        $em->remove($isCandidate);
        $em->remove($visitCard);
        $em->flush();

        $this->addFlash(
            'notice',
            'Suppression ok'
        );

        return $this->redirectToRoute('candidate_profil');
    }
}
