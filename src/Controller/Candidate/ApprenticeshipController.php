<?php

namespace App\Controller\Candidate;

use App\Entity\School;
use App\Entity\Formation;
use App\Entity\VisitCard;
use App\Entity\IsCandidate;
use App\Entity\IsApprenticeship;
use App\Form\ApprenticeshipType;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Manager\SchoolManager;
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
    public function add(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        // je récupère sa fiche candidat
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);

        // récupération de la carte de visite du candidat connecté
        $visitCardRepo = $em->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);

        // je vérifie si le candidat à déjà enregistré une recherche d'alternance
        $formationRepo = $em->getRepository(Formation::class);
        $alreadyRegister = $formationRepo->findOneBy(['visitCard' => $visitCard, 'status' => 2]);

        // si le candidat a déjà enregistré une recherche
        if(!empty($alreadyRegister))
        {
            // message + redirection
            $this->addFlash('warning', 'Vous avez déjà une recherche d\'alternance en cours, vous pouvez la modifier ou la supprimer.');

            return $this->redirectToRoute('candidate_profile');
        }

        // je récupère le contenu du formulaire
        $data = $request->request->get('apprenticeship');

        // je l'envoi à la méthode checkSchoolData pour vérifier son contenu
        $newData = SchoolManager::checkSchoolData($data, $em);

        // si la méthode m'a renvoyé autre que chose du null
        if(!empty($newData))
        {
            // je met à jour ma requête en écrasant les anciennes donnée
            $request->request->set('apprenticeship',$newData);
        }

        $apprenticeship = new IsApprenticeship();
        
        $form = $this->createForm(ApprenticeshipType::class, $apprenticeship);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            // récupération des infos à enregistrer
            $apprenticeship = $form->getData();
            // ajout des info nécessaire à l'enregistrement
            $apprenticeship
                ->getFormation()
                ->setVisitCard($visitCard)
                ->setStatus(2);

            $em = $this->getDoctrine()->getManager();

            // enregistrement en bdd ( par un effet "cascade", la formation sera enregistré aussi )
            $em->persist($apprenticeship);
            $em->flush($apprenticeship);

            return $this->redirectToRoute('candidate_profile');
        }

        return $this->render('candidate/profile/apprenticeship.html.twig', [
            'tab_type' => 'Ajouter',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit(Request $request, $id, EntityManagerInterface $em)
    {
        // je récupère le user
        $user = $this->getUser();
        // je récupère sa fiche candidat
        $candidateRepo = $em->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);
        // je récupère la carte de visite du candidat
        $visitCardRepo = $em->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);
        // je récupère la formation du candidat connecté, qui doit être modifié
        $formationRepo = $em->getRepository(Formation::class);
        $formation = $formationRepo->findOneBy(['id' => $id, 'visitCard' => $visitCard->getId()]);

        // si cette formation appartient bien au candidat connecté
        if(!empty($formation))
        {
            // je récupère l'alternance à modifier
            $apprenticeshipRepo = $em->getRepository(IsApprenticeship::class);
            $apprenticeship = $apprenticeshipRepo->findOneBy(['formation' => $formation->getId()]);
            
            // si je récupère bien une alternance
            if(!empty($apprenticeship))
            {
                // je récupère le contenu du formulaire
                $data = $request->request->get('apprenticeship');

                // je l'envoi à la méthode checkSchoolData pour vérifier son contenu
                $newData = SchoolManager::checkSchoolData($data, $em);

                // si la méthode m'a renvoyé autre que chose du null
                if(!empty($newData))
                {
                    // je met à jour ma requête en écrasant les anciennes donnée
                    $request->request->set('apprenticeship',$newData);
                }
                
                $form = $this->createForm(ApprenticeshipType::class, $apprenticeship);

                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) 
                {
                    // récupération des infos à enregistrer
                    $editApprenticeship = $form->getData();

                    // enregistrement en bdd ( par un effet "cascade", la formation sera enregistré aussi )
                    $this->getDoctrine()->getManager()->flush();

                    return $this->redirectToRoute('candidate_profile');
                }
            }
            // si cette formation n'est pas une alternance
            else 
            {
                $this->addFlash('danger', 'Une erreur est survenue.');
                return $this->redirectToRoute('candidate_profile');
            }
        }
        // si cette formation n'appartient pas au user connecté
        else 
        {
            $this->addFlash('danger', 'Une erreur est survenue.');
            return $this->redirectToRoute('candidate_profile');
        }

        return $this->render('candidate/profile/apprenticeship.html.twig', [
            'tab_type' => 'Modifier',
            'form' => $form->createView(),
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
        // je récupère la formation du candidat connecté, qui doit être supprimé
        $formationRepo = $this->getDoctrine()->getRepository(Formation::class);
        $formation = $formationRepo->findOneBy(['id' => $id, 'visitCard' => $visitCard->getId()]);

        // si cette formation appartient bien au candidat connecté
        if(!empty($formation))
        {
            $apprenticeshipRepo = $this->getDoctrine()->getRepository(IsApprenticeship::class);
            $apprenticeship = $apprenticeshipRepo->findOneBy(['formation' => $formation->getId()]);
            
            $em = $this->getDoctrine()->getManager();
            // je le supprime
            $em->remove($apprenticeship);
            $em->flush();

            $this->addFlash('notice', 'Votre alternance a bien été supprimée.');
        }
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue lors de la suppression.');
        }

        return $this->redirectToRoute('candidate_profile');
    }
}
