<?php

namespace App\Controller\Candidate;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Entity\VisitCard;
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

}
