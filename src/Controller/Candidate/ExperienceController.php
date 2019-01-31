<?php

namespace App\Controller\Candidate;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/candidat/experience", name="experience_")
 */
class ExperienceController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add()
    {
        return $this->render('candidate/profile/experience.html.twig', [
            'controller_name' => 'ExperienceController',
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit()
    {
        return $this->render('candidate/profile/experience.html.twig', [
            'controller_name' => 'ExperienceController',
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
