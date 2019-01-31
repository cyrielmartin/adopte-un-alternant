<?php

namespace App\Controller\Candidate;

use App\Entity\VisitCard;
use App\Entity\Experience;
use App\Form\ExperienceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
            // ajout des info nécessaire à l'enregistrement
            $experience = $form->getData();
            
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

            // enregistrement en bdd ( par un effet "cascarde", la formation sera enregistré aussi )
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
