<?php

namespace App\Controller\Candidate;

use App\Entity\VisitCard;
use App\Entity\Experience;
use App\Form\ExperienceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


//Nb pour les fonctions add et edit, le contrôle de la cohérence des dates a été fait grâce aux annotations Assert directement dans les entity ou encore grace aux constraints directement dans l'ExperienceType

/**
 * @Route("/candidat/experience", name="experience_")
 */
class ExperienceController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add(Request $request)
    {
        $user = $this->getUser();

         // récupération de la carte de visite du candidat connecté
         $visitCardRepo = $this->getDoctrine()->getRepository(VisitCard::class);
         $visitCard = $visitCardRepo->findOneBy(['id' => $user->getId()]);

        $experience = new Experience();
        
        $form = $this->createForm(ExperienceType::class, $experience);

        $form->handleRequest($request);

    
        if ($form->isSubmitted() && $form->isValid()) 
        { //dd($request);
            // ajout des info nécessaires à l'enregistrement
            $experience = $form->getData();
            
            $experience->setVisitCard($visitCard);
            $status=$experience->getStatus();
            //$endedDate=$experience ->getEndedAt();
            //dd($endedDate);

            //dd($status);
            if ($status == true){
                $endedDate= null;
                $experience->setEndedAt(null);
                
            }

            else {
                $endedDate=$experience ->getEndedAt();
                $experience->setEndedAt($endedDate);
                //dd($endedDate);
            }

            $this->addFlash(
                'notice',
                'Votre expérience a bien été ajoutée'
            );




            $em = $this->getDoctrine()->getManager();

            // enregistrement en bdd ( par un effet "cascade", l'experience sera enregistré aussi )
            $em->persist($experience);
            $em->flush($experience);

            return $this->redirectToRoute('candidate_profile');
        }


        return $this->render('candidate/profile/experience.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit(Request $request, Experience $experience)

    {
        $user = $this->getUser();

        // récupération de la carte de visite du candidat connecté
        $visitCardRepo = $this->getDoctrine()->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['id' => $user->getId()]);

        $experienceForm = $this->createForm(ExperienceType::class, $experience);
        $experienceForm->handleRequest($request);
        if ($experienceForm->isSubmitted() && $experienceForm->isValid()) {      
            $experience->setVisitCard($visitCard);
            $status=$experience->getStatus();

            //dd($status);
            if ($status == false){
                $endedDate=$experience ->getEndedAt();
                $experience->setEndedAt($endedDate);
                //dd($endedDate);
            }

            else {
                $endedDate=null;
                $experience->setEndedAt($endedDate);
            }

            $em = $this->getDoctrine()->getManager();

            // enregistrement en bdd
            $em->persist($experience);
            $em->flush();

            $this->addFlash(
                'notice',
                'Votre expérience a bien été modifiée'
            );

            return $this->redirectToRoute('candidate_profile');
        }
        
        return $this->render('candidate/profile/experience_edit.html.twig', [
            'experienceForm'=>$experienceForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/supprimer", name="delete")
     */
    public function delete($id)
    {
        // je récupère l'experience qui doit être supprimée
        $experienceRepo = $this->getDoctrine()->getRepository(Experience::class);
        $experience = $experienceRepo->findOneById($id);
        
        $em = $this->getDoctrine()->getManager();
        // je la supprime
        $em->remove($experience);
        $em->flush();
        $this->addFlash('success', 'Votre expérience a bien été supprimée.');
        return $this->redirectToRoute('candidate_profile');
    }
}
