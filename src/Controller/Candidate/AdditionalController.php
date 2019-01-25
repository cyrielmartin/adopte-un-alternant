<?php

namespace App\Controller\Candidate;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/candidat/information-complementaire", name="additional_")
 */
class AdditionalController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add()
    {
        return $this->render('candidate/profil/additional.html.twig', [
            'controller_name' => 'AdditionalController',
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit()
    {
        return $this->render('candidate/profil/additional.html.twig', [
            'controller_name' => 'AdditionalController',
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
