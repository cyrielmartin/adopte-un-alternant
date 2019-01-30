<?php

namespace App\Controller\Candidate;

use App\Entity\IsCandidate;
use App\Form\IsCandidateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidat/image", name="candidate_picture")
 */
class PictureController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add()
    {
        return $this->render('candidate/profile/picture.html.twig', [
            'controller_name' => 'PictureController',
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit(IsCandidate $isCandidate, Request $request, EntityManagerInterface $em)
        {
            $isCandidateForm = $this->createForm(IsCandidateType::class, $isCandidate);
            $isCandidateForm->handleRequest($request);
            if ($isCandidateForm->isSubmitted() && $isCandidateForm->isValid()) {
                $em->persist($isCandidate);
                $em->flush();
                
                $this->addFlash(
                    'notice',
                    'La photo a bien été modifiée'
                );
                return $this->redirectToRoute('about_edit', ['id' => $user->getId()]);
            }
    
        return $this->render('candidate/profile/picture.html.twig', [
            'isCandidateForm' => $isCandidateForm->createView(),
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
