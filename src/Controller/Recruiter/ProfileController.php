<?php

namespace App\Controller\Recruiter;

use App\Form\UserEditType;
use App\Entity\IsRecruiter;
use App\Form\RecruiterInfoType;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Manager\MobilityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Manager\RecruiterMobilityManager;
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
    public function recruiterInfoEdit(Request $request, EntityManagerInterface $em)
    {
        /** 
         * Page de modification des infos recruteur : nom entreprise , localité de l'entreprise, téléphone 
        */
        $user = $this->getUser();
        //dump($user);

        // je récupère sa fiche isRecruiter
        $recruiterRepo = $this->getDoctrine()->getRepository(IsRecruiter::class);
        $recruiter = $recruiterRepo->findOneBy(['user' => $user->getId()]);
        //dump($recruiter);

       
        $form = $this->createForm(RecruiterInfoType::class, $recruiter);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid())
        { 
            $mobility = $form->getData();
            dump($mobility);

            // je vérifie que la ville existe
            $town = RecruiterMobilityManager::isRealTown($mobility);
            //$townName=$town['nom'];
            //sdump($townName);
            dump($town);

            // si la clef fail existe, l'api n'a renvoyé aucun résultat
            // c'est donc un message d'erreur qui a été retourné
            if(isset($town['fail']))
            {
                $this->addFlash('danger', $town['fail']);
                return $this->redirectToRoute('recruiter_company_informations');
            }
            // sinon l'api a renvoyé un résultat
            // $town['success'] contient le tableau de réponse renvoyé par l'api
            //$mobility = RecruiterMobilityManager::recoverMobility($town, $em);
            $recruiter->setCompanyLocation($town['nom']);
            
            $em->flush();
            $this->addFlash(
                'notice',
                'Votre fiche a bien été modifiée'
            );
            
            return $this->redirectToRoute('recruiter_profile');
        }


        return $this->render('recruiter/profile/recruiter_info.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
