<?php

namespace App\Controller\Recruiter;

use App\Entity\VisitCard;
use App\Entity\IsRecruiter;
use App\Entity\IsApprenticeship;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/recruteur", name="recruiter_")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/profil", name="profile")
     */
    public function show(EntityManagerInterface $em)
    {
        // récupération user
        $user = $this->getUser();
        // récupération info recruteur complémentaire
        $recruiterRepo = $em->getRepository(IsRecruiter::class);
        $recruiter = $recruiterRepo->findOneBy(['user' => $user->getId()]);
        // récupération des favoris du recruteur
        $favorites = $recruiter->getIsCandidates();

        $visitCardRepo = $em->getRepository(VisitCard::class);
        
        $favoritesData = array();

        // pour chaque favoris (isCandidate)
        foreach ($favorites as $favorite)
        {
            // je récupère la carte de visite du candidat
            $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $favorite->getId()]);
            // ses formations
            $formations = $visitCard->getFormations();

            // je parcours les formations à la recherche de l'alternance recherché
            foreach($formations as $formation)
            {
                if($formation->getStatus() === 2)
                {
                    // que je récupère dans $apprenticeship
                    $apprenticeship = $formation;
                }
            }
        
            $apprenticeRepo = $em->getRepository(IsApprenticeship::class);
            
            // je rassemble les information concernant le candidat et l'alternance qu'il recherche
            $favoritesData[] = [
                'candidate' => $favorite,
                'visitCard' => $visitCard, 
                'formationInfo' => $apprenticeship,
                'apprenticeshipInfo' => $apprenticeRepo->findOneBy(['formation' => $apprenticeship->getId()]),
            ];
        }
        /** 
         * Page profil du recruteur, affichant : 
         * - Info perso : nom prénom mail (mdp)
         * - Info recruteur : nom entreprise , localité de l'entreprise, téléphone 
         *      - préciser que s'il ne donne pas le nom de son entreprise il n'aura pas accès à toutes les fonctionnalités
         *        du site tel que l'envoie de mail en un clic et les favoris !
         * - Contenu du mail à envoyer par défaut ( avec bouton --> personnaliser )
         * - Liste des candidats favoris ( avec lien vers leur profil )
        */
        return $this->render('recruiter/profile/profile.html.twig', [
            'recruiter' => $recruiter,
            'favorites' => $favoritesData,
        ]);
    }

    /**
     * @Route("/information-personnelle", name="informations")
     */
    public function userInfoEdit()
    {
        /** 
         * Page de modification des infos personnelles : nom prénom mail (mdp)
        */
        return $this->render('recruiter/profile/user_info.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    /**
    * @Route("/information-entreprise", name="company_informations")
    */
    public function recruiterInfoEdit()
    {
        /** 
         * Page de modification des infos recruteur : nom entreprise , localité de l'entreprise, téléphone 
        */
        return $this->render('recruiter/profile/recruiter_info.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}
