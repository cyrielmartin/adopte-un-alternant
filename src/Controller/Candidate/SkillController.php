<?php

namespace App\Controller\Candidate;

use App\Entity\Skill;
use App\Form\SkillType;
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
     * @Route("/ajouter", name="add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($skill);
            $em->flush();
            
            return $this->redirectToRoute('candidate_profile');
        }

        return $this->render('candidate/profile/skill.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */

    public function edit(Skill $skill, Request $request, EntityManagerInterface $em)
    {
    $form = $this->createForm(SkillType::class, $skill);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($skill);
        $em->flush();

        return $this->redirectToRoute('candidate_profile');
    }

    return $this->render('candidate/profile/skill.html.twig', [
        'form' => $form->createView(),
    ]);
}

    /**
     * @Route("/{id}/supprimer", name="delete")
     */
    public function delete(Skill $skill, EntityManagerInterface $em)
    {
        $em->remove($skill);
        $em->flush();
        
        return $this->redirectToRoute('candidate_profile');
    }
}
