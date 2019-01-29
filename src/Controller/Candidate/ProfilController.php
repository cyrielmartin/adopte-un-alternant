<?php

namespace App\Controller\Candidate;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\IsCandidateRepository;
use App\Repository\VisitCardRepository;
use App\Repository\WebsiteRepository;
use App\Repository\FormationRepository;
use App\Repository\ExperienceRepository;
use App\Repository\SkillRepository;
use App\Repository\AdditionalRepository;
use App\Repository\MobilityRepository;

/**
 * @Route("/candidat", name="candidate_")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function show(IsCandidateRepository $isCandidateRepo, VisitCardRepository $visitCardRepo, WebsiteRepository $webSiteRepo, FormationRepository $formationRepo, ExperienceRepository $experienceRepo, SkillRepository $skillRepo, AdditionalRepository $additionalRepo, MobilityRepository $mobilityRepo)
    {
        // Affiche le profil du user 
        // Pas de form ici ( seulement de la récupèration d'info pour affichage )
        $user = $this->getUser();
        $userId= $user->getId();
        
        $candidateDatas= $isCandidateRepo->findOneByuser($userId);

        //récupération de l'Id pour accéder aux visitCards
        $candidateId=$candidateDatas->getId();

        $candidateInformation = $visitCardRepo->findOneByIsCandidate($candidateId);
        //dd ($candidateInformation);

        //récupération de l'Id de la visitCard pour accéder aux metatables
        $visitCardId = $candidateInformation->getId();
       
        $webSite = $webSiteRepo->findOneByVisitCard($visitCardId);
       
        $formationsInfo=$formationRepo->findByVisitCard($visitCardId);
        //dd ($formationsInfo);

        $experiencesInfo =$experienceRepo->findByVisitCard($visitCardId);


        //création d'un requête join dans le fichier skill repo pour récupérer les compétences par Id de visitCard
        $skillsInfo = $skillRepo ->findByVisitCard($visitCardId);
        //dd ($skillsInfo);

        $additionalsInfo = $additionalRepo ->findByVisitCard($visitCardId);
        //dd($additionalsInfo);

        //création d'un requête join dans le fichier mobilityRepo pour récupérer les mobilités du candidat par Id de visitCard
        $mobilitiesInfo = $mobilityRepo ->findByVisitCard($visitCardId);
        //dump ($mobilitiesInfo);

     
        

        return $this->render('candidate/profil/profil.html.twig', [
            'candidateDatas' =>  $candidateDatas,
            'candidateInformation' => $candidateInformation,
            'webSite'=>$webSite,
            'formationsInfo'=>$formationsInfo,
            'experiencesInfo'=>$experiencesInfo,
            'skillsInfo'=>$skillsInfo,
            'additionalsInfo'=>$additionalsInfo,
            'mobilitiesInfo'=>$mobilitiesInfo,
            'visitCardId'=>$visitCardId

        ]);
    }

    /**
     * @Route("/information-personelle", name="informations")
     */
    public function userInfoEdit()
    {
        // Affiche / traite le(s) formulaire(s) réunissant les infos personelles propre à TOUT les user (nom prénom email mot de passe)
        // ainsi que les info complémentaires propre au role candidat  (telephone picture)
        
        return $this->render('candidate/profil/user_info.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    // pas de suppression possible au niveau des info perso, seulement de la modification

}
