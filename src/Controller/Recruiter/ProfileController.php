<?php

namespace App\Controller\Recruiter;

use App\Form\UserEditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    public function userInfoEdit(Request $request, UserPasswordEncoderInterface $encoder)
    {
        /** 
         * Page de modification des infos personnelles : nom prénom mail (mdp)
        */

        // je récupère mon user en session
        $user = $this->getUser();
        // ainsi que son ancien mot de passe
        $oldPass = $user->getPassword();
        $form = $this->createForm(UserEditType::class, $user);
        
        $form->handleRequest($request);
     
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // si le form contient un mdp vite, je garde l'ancien
            if (empty($user->getPassword()) || is_null($user->getPassword()))
            {
                $encodedPass = $oldPass;
            } 
            // sinon je l'encode
            else 
            {
                $encodedPass = $encoder->encodePassword($user, $user->getPassword());
            }
            $user->setPassword($encodedPass);
            $user->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('recruiter_profile');
        }
        return $this->render('recruiter/profile/user_info.html.twig', [
            'form' => $form->createView(),
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
