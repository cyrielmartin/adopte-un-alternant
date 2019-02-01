<?php

namespace App\Controller\Candidate;

use App\Entity\Formation;
use App\Entity\VisitCard;
use App\Form\FormationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Manager\SchoolManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidat/formation", name="formation_")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();

        // je récupère le contenu du formulaire
        $data = $request->request->get('formation');

        // je l'envoi à la méthode checkSchoolData pour vérifier son contenu
        $newData = SchoolManager::checkSchoolData($data, $em);

        // si la méthode m'a renvoyé autre que chose du null
        if(!empty($newData))
        {
            // je met à jour ma requête en écrasant les anciennes donnée
            $request->request->set('formation',$newData);
        }

        $formation = new Formation();
        
        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $formation = $form->getData();

            $end = $formation->getEndedAt();
            $now = new \DateTime();
            // si la fin de la formation est avant aujourd'hui
            if( $now >= $end )
            {
                // status -> formation terminé
                $formation->setStatus(0);
            }
            // si la fin de la formation est après aujourd'hui
            else if ( $now < $end )
            {
                // status -> formation toujours en cours
                $formation->setStatus(1);
            }
            
            // récupération de la carte de visite du candidat connecté
            $visitCardRepo = $em->getRepository(VisitCard::class);
            $visitCard = $visitCardRepo->findOneBy(['id' => $user->getId()]);

            // enregistrement en bdd
            $formation->setVisitCard($visitCard);
            $em->persist($formation);
            $em->flush();

            return $this->redirectToRoute('candidate_profile');
        }

        return $this->render('candidate/profile/formation.html.twig', [
            'tab_type' => 'Ajouter',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit(Request $request, $id, EntityManagerInterface $em)
    {
        // je récupère la formation qui doit être modifié
        $formationRepo = $em->getRepository(Formation::class);
        $formation = $formationRepo->findOneBy(['id' => $id]);

        // je récupère le contenu du formulaire
        $data = $request->request->get('formation');
        $newData = SchoolManager::checkSchoolData($data, $em);

        // si la méthode m'a renvoyé autre que chose du null
        if(!empty($newData))
        {
            // je met à jour ma requête en écrasant les anciennes donnée
            $request->request->set('formation',$newData);
        }
        
        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $formation = $form->getData();

            $end = $formation->getEndedAt();
            $now = new \Datetime();

            // si la fin de la formation est avant aujourd'hui
            if( $now >= $end )
            {
                // status -> formation terminé
                $formation->setStatus(0);
            }
            // si la fin de la formation est après aujourd'hui
            else if ( $now < $end )
            {
                // status -> formation toujours en cours
                $formation->setStatus(1);
            }

            // enregistrement en bdd
            $em->flush();

            return $this->redirectToRoute('candidate_profile');
        }

        return $this->render('candidate/profile/formation.html.twig', [
            'tab_type' => 'Modifier',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/supprimer", name="delete")
     */
    public function delete($id)
    {
        // je récupère la formation qui doit être supprimé
        $formationRepo = $this->getDoctrine()->getRepository(Formation::class);
        $formation = $formationRepo->findOneBy(['id' => $id]);
        
        $em = $this->getDoctrine()->getManager();
        // je le supprime
        $em->remove($formation);
        $em->flush();

        $this->addFlash('notice', 'La formation a bien été supprimé.');
 
        return $this->redirectToRoute('candidate_profile');
    }
}
