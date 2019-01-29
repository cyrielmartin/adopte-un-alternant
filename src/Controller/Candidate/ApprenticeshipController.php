<?php

namespace App\Controller\Candidate;

use App\Entity\Formation;
use App\Entity\IsApprenticeship;
use App\Form\ApprenticeshipType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidat/alternance", name="apprenticeship_")
 */
class ApprenticeshipController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add(Request $request)
    {
        $user = $this->getUser();
        dump($user);
        $apprenticeship = new IsApprenticeship();
        
        $form = $this->createForm(ApprenticeshipType::class, $apprenticeship);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            dd('validé');
        }

        return $this->render('candidate/profil/apprenticeship.html.twig', [
            'tab_type' => 'Ajouter',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit()
    {
        return $this->render('candidate/profil/apprenticeship.html.twig', [
            'tab_type' => 'Modifier',
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
