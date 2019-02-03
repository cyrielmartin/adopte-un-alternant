<?php

namespace App\Controller\Recruiter;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/recruteur", name="recruiter_")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/profil", name="profile")
     */
    public function show()
    {
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
            'controller_name' => 'ProfileController',
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
