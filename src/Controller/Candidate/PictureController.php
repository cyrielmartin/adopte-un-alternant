<?php

namespace App\Controller\Candidate;

use App\Entity\IsCandidate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\PictureType;

/**
 * @Route("/candidat/image", name="picture_")
 */
class PictureController extends AbstractController
{

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit(IsCandidate $isCandidate, Request $request, EntityManagerInterface $em)
        {
            $pictureForm = $this->createForm(PictureType::class, $isCandidate);
            $pictureForm->handleRequest($request);
            if ($pictureForm->isSubmitted() && $pictureForm->isValid()) {
                $em->persist($isCandidate);
                $em->flush();
                
                $this->addFlash(
                    'notice',
                    'La photo a bien été modifiée'
                );
                return $this->redirectToRoute('candidate_profile');
            }
    
        return $this->render('candidate/profile/picture.html.twig', [
            'pictureForm' => $pictureForm->createView(),
        ]);
    }
}
