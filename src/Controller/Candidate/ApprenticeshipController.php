<?php

namespace App\Controller\Candidate;

use App\Entity\School;
use App\Entity\Formation;
use App\Entity\VisitCard;
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

        // récupération de la carte de visite du candidat connecté
        $visitCardRepo = $this->getDoctrine()->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['id' => $user->getId()]);

        // je vérifie si le candidat à déjà enregistré une recherche d'alternance
        $formationRepo = $this->getDoctrine()->getRepository(Formation::class);
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
        $newData = $this->checkSchoolData($data);

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
    public function edit(Request $request, $id)
    {
        // je récupère l'apprentissage qui doit être modifié
        $apprenticeRepo = $this->getDoctrine()->getRepository(IsApprenticeship::class);
        $apprenticeship = $apprenticeRepo->findOneBy(['formation' => $id]);

        // je récupère le contenu du formulaire
        $data = $request->request->get('apprenticeship');

        // je l'envoi à la méthode checkSchoolData pour vérifier son contenu
        $newData = $this->checkSchoolData($data);

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
            //dd($editApprenticeship);

            // enregistrement en bdd ( par un effet "cascade", la formation sera enregistré aussi )
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('candidate_profile');
        }

        return $this->render('candidate/profile/apprenticeship.html.twig', [
            'tab_type' => 'Modifier',
            'form' => $form->createView(),
        ]);
    }

    /** 
     * Fonction qui récupère le contenu d'une requête et le met à jour si
     * l'école est renseigné, et existe en base ou non.
    */
    public function checkSchoolData($data)
    {
        // Si le champ School a bien été renseigné
        if(!empty($data['formation']['school']))
        {
            // Je récupère le nom de l'école en virant les espaces
            $schoolName = trim($data['formation']['school']);

            // Si le nom n'est pas vide
            if(!empty($schoolName))
            {
                // je récupère le repository
                $schoolRepo = $this->getDoctrine()->getManager()->getRepository(School::class);
                // et cherche si l'école existe
                $schoolExist = $schoolRepo->findOneBy(['name' => $schoolName]);

                // si l'école n'existe pas
                if(empty($schoolExist))
                {
                    // j'appelle la fonction addSchool pour l'ajouter 
                    $newSchool = $this->addSchool($schoolName);
                    // je met à jour data avec l'école ajouté en bdd
                    $data['formation']['school'] = $newSchool;

                }
                // si l'école existe
                else
                {
                    // on met à jour data avec l'école déjà présente en bdd
                    $data['formation']['school'] = $schoolExist;
                }
            }
            // Si après trim le champ school était vide data deviens null
            else
            {
                $data = null;
            }
        }
        // Si le champs school n'était pas renseigné data deviens null
        else
        {
            $data = null;
        }

        return $data;
    }

    /** 
     * Méthode permettant d'enregistrer un nouvel établissement de formation
     * en BDD.
     * Prend 1 paramètre : le nom de l'établissement à ajouter
    */
    public function addSchool($schoolName)
    {
        // je créer un nouvel objet école
        $school = new School();
        // je lui envoi un nom
        $school->setName($schoolName);

        $em = $this->getDoctrine()->getManager();

        // je l'enregistre en bdd
        $em->persist($school);
        $em->flush($school);
        // je refresh mon objet pour récupèrer l'id enregistré en base
        $em->refresh($school);

        return $school;
    }

    /**
     * @Route("/{id}/supprimer", name="delete")
     */
    public function delete($id)
    {
        // je récupère l'apprentissage qui doit être supprimé
        $apprenticeRepo = $this->getDoctrine()->getRepository(IsApprenticeship::class);
        $apprenticeship = $apprenticeRepo->findOneBy(['formation' => $id]);
        
        $em = $this->getDoctrine()->getManager();
        // je le supprime
        $em->remove($apprenticeship);
        $em->flush();

        $this->addFlash('success', 'Votre alternance a bien été supprimé.');

        return $this->redirectToRoute('candidate_profile');
    }
}
