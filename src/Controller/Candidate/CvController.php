<?php

namespace App\Controller\Candidate;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/candidat/curriculum-vitae", name="cv_")
 */
class CvController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add()
    {
        return $this->render('candidate/profile/cv.html.twig', [
            'controller_name' => 'CvController',
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit()
    {
        return $this->render('candidate/profile/cv.html.twig', [
            'controller_name' => 'CvController',
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
