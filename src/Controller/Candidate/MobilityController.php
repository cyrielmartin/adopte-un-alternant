<?php

namespace App\Controller\Candidate;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/candidat/localisation", name="mobility_")
 */
class MobilityController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add()
    {
        return $this->render('candidate/profile/mobility.html.twig', [
            'controller_name' => 'MobilityController',
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit()
    {
        return $this->render('candidate/profile/mobility.html.twig', [
            'controller_name' => 'MobilityController',
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