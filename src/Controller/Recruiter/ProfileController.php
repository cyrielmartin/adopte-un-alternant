<?php

namespace App\Controller\Recruiter;

use App\Entity\Mobility;
use App\Entity\VisitCard;
use App\Form\UserEditType;
use App\Entity\IsRecruiter;
use App\Form\RecruiterInfoType;
use App\Entity\IsApprenticeship;
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
                'formationInfo' => isset($apprenticeship) ? $apprenticeship : null,
                'apprenticeshipInfo' => isset($apprenticeship) ? $apprenticeRepo->findOneBy(['formation' => $apprenticeship->getId()]) : null,
            ];
        }

        return $this->render('recruiter/profile/profile.html.twig', [
            'recruiter' => $recruiter,
            'favorites' => $favoritesData,
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
            // je récupère les infos du recruteur
            $recruiter = $form->getData();
            // le nom de la ville de l'entreprise
            $townName = $recruiter->getCompanyLocation();
            // je formate le nom de la ville
            $townName = MobilityManager::replaceAccent($townName);
            // je créer un objet mobility et lui donne le nom de la ville
            $mobility = new Mobility();
            $mobility->setTownName($townName);

            // je vérifie que la ville existe 
            // (la méthode isRealTown attend un objet mobility en paramètre)
            $town = MobilityManager::isRealTown($mobility);

            // si la clef fail existe, l'api n'a renvoyé aucun résultat
            // c'est donc un message d'erreur qui a été retourné
            if(isset($town['fail']))
            {
                $this->addFlash('danger', $town['fail']);
                return $this->redirectToRoute('recruiter_company_informations');
            }
            // sinon l'api a renvoyé un résultat
            // $town['success'] contient le tableau de réponse renvoyé par l'api
            // j'envoi le tableau réponse à recoverMobility() pour l'enregistrer en base au cas ou elle n'existerais pas
            MobilityManager::recoverMobility($town, $em);
            // j'ajoute la ville dans mon objet recruiter
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
