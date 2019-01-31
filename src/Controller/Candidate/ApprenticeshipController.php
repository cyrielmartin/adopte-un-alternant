<?php

namespace App\Controller\Candidate;

use App\Entity\School;
use App\Entity\Formation;
use App\Entity\VisitCard;
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

        // récupération de la carte de visite du candidat connecté
        $visitCardRepo = $em->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['id' => $user->getId()]);

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
            // ajout des info nécessaire à l'enregistrement
            $apprenticeship = $form->getData();
            $apprenticeship
                ->getFormation()
                ->setVisitCard($visitCard)
                ->setStatus(2);

            // enregistrement en bdd ( par un effet "cascarde", la formation sera enregistré aussi )
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
    public function edit()
    {
        return $this->render('candidate/profile/apprenticeship.html.twig', [
            'tab_type' => 'Modifier',
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
