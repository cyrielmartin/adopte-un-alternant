<?php

namespace App\Controller\Candidate;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/candidat/site", name="website_")
 */
class WebsiteController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add()
    {
        return $this->render('candidate/profile/website.html.twig', [
            'controller_name' => 'WebsiteController',
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit()
    {
        return $this->render('candidate/profile/website.html.twig', [
            'controller_name' => 'WebsiteController',
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