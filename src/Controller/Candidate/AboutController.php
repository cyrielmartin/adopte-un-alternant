<?php

namespace App\Controller\Candidate;

use App\Form\AboutType;
use App\Entity\VisitCard;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidat/a-propos", name="about_")
 */
class AboutController extends AbstractController
{
    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit(VisitCard $visitCard, Request $request, EntityManagerInterface $em)
    {
        $aboutForm = $this->createForm(AboutType::class, $visitCard);
        $aboutForm->handleRequest($request);
        if ($aboutForm->isSubmitted() && $aboutForm->isValid()) {
            $em->persist($visitCard);
            $em->flush();
            
            $this->addFlash(
                'notice',
                'Votre présentation a bien été modifiée'
            );
            return $this->redirectToRoute('candidate_profile');
        }
        return $this->render('candidate/profile/about.html.twig', [
            'aboutForm' => $aboutForm->createView(),
        ]);
    }

}
