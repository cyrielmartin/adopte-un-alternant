<?php

namespace App\Controller\Candidate;

use App\Entity\VisitCard;
use App\Entity\Experience;
use App\Entity\IsCandidate;
use App\Form\ExperienceType;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Manager\SchoolManager;
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
        // je récupère sa fiche candidat
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);

        // récupération de la carte de visite du candidat connecté
        $visitCardRepo = $this->getDoctrine()->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);

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
            'tab_type' => 'Ajouter',
            
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit(Request $request, $id, EntityManagerInterface $em)
    {
        $user = $this->getUser();

        // je récupère sa fiche candidat
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);

        // récupération de la carte de visite du candidat connecté
        $visitCardRepo = $em->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);

        // je récupère l'expérience qui doit être mise à jours
        $experienceRepo = $this->getDoctrine()->getRepository(Experience::class);
        $experience = $experienceRepo->findOneBy(['visitCard' => $visitCard->getId(), 'id' => $id]);

        // si cette expérience appartient bien au candidat connecté
        if(!empty($experience))
        {
            $form = $this->createForm(ExperienceType::class, $experience);
            $form->handleRequest($request);

        
            if ($form->isSubmitted() && $form->isValid())
            { 
                //$experience = $form->getData();
                //$experience->setVisitCard($visitCard);
                $status=$experience->getStatus();
                //dd($status);
    
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
            
                // enregistrement en bdd
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Votre expérience a bien été modifiée'
                );
                
                return $this->redirectToRoute('candidate_profile');
            }
        }
        // si cette formation n'appartient pas au user connecté
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue');
            
            return $this->redirectToRoute('candidate_profile');
            
        }
        return $this->render('candidate/profile/experience.html.twig', [
            'form'=>$form->createView(),
            'tab_type' => 'Modifier',
        ]);
        
    }

    /**
     * @Route("/{id}/supprimer", name="delete")
     */
    public function delete($id)
    {
        // je récupère le user
        $user = $this->getUser();
        // je récupère sa fiche candidat
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);
        // je récupère la carte de visite du candidat
        $visitCardRepo = $this->getDoctrine()->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);
        $visitCardId =$visitCard->getId();
        
        // je récupère l'expérience qui doit être supprimée
        $experienceRepo = $this->getDoctrine()->getRepository(Experience::class);
        $experienceToDelete = $experienceRepo->findOneBy(['id' => $id, 'visitCard' => $visitCard->getId()]);
        //dd($experienceToDelete);

        // si l'experience appartient bien au user alors experienceToDelete n'est pas vide
        
        if(!empty($experienceToDelete))
        {
            $em = $this->getDoctrine()->getManager();
            // je la supprime
            $em->remove($experienceToDelete);
            $em->flush();

            $this->addFlash('notice', 'Votre expérience a bien été supprimée.');
        }
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue lors de la suppression.');
        }
        
        return $this->redirectToRoute('candidate_profile');
    }
}
