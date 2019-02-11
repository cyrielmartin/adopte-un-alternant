<?php

namespace App\Controller\Candidate;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Entity\VisitCard;
use App\Entity\IsCandidate;
use App\Form\SkillVisitCardType;
use App\Form\VisitCardSkillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidat/competence", name="skill_")
 */
class SkillController extends AbstractController
{

    /**
     * @Route("/{id}/modifier", name="edit")
     */

    public function edit(VisitCard $visitCard, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(VisitCardSkillType::class, $visitCard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($visitCard);
            $em->flush();

            $this->addFlash(
            'notice',
            'Les compétences ont bien été modifiées'
        );
            return $this->redirectToRoute('candidate_profile');
        }

        return $this->render('candidate/profile/skill.html.twig', [
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
        // je récupère la compétence via son id
        $skillRepo = $this->getDoctrine()->getRepository(Skill::class);
        $skill = $skillRepo->find($id);
        
        // si cette compétence existe
        if (!empty($skill)) {
            // je supprime la relation avec celle-ci de la carte de visite du candidat
            $visitCard->removeSkill($skill);

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('notice', 'La compétence a bien été supprimée.');
        }
        // si la compétence n'existe pas
        else {
            $this->addFlash('danger', 'Une erreur est survenue lors de la suppression.');
        }
        
        return $this->redirectToRoute('candidate_profile');
    }
}