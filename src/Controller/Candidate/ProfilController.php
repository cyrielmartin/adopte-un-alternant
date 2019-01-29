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

/**
 * @Route("/candidat", name="candidate_")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/profil/{id}", name="profil")
     */
    public function show(User $user, IsCandidateRepository $isCandidateRepo, VisitCardRepository $visitCardRepo, WebsiteRepository $webSiteRepo, FormationRepository $formationRepo, ExperienceRepository $experienceRepo, SkillRepository $skillRepo)
    {
        // Affiche le profil du user 
        // Pas de form ici ( seulement de la récupèration d'info pour affichage )
        $userId= $user->getId();
        
        $candidateDatas= $isCandidateRepo->findOneByuser($userId);
        //dump($candidateDatas);

        $candidateId=$candidateDatas->getId();
        //dump($candidateId);

        $candidateInformation = $visitCardRepo->findOneByIsCandidate($candidateId);
        //dump($candidateInformation);

        $visitCardId = $candidateInformation->getId();
        //dd($visitCardId);
        $webSite = $webSiteRepo->findOneByVisitCard($visitCardId);
        //dd($webSite);
        $formationsInfo=$formationRepo->findByVisitCard($visitCardId);
        //dd($formationsInfo);

        $experiencesInfo =$experienceRepo->findByVisitCard($visitCardId);
        //dd($experiencesInfo);

        $skillsInfo = $skillRepo ->findByVisitCard($visitCardId);
        //dd ($skillsInfo);

     
        

        return $this->render('candidate/profil/profil.html.twig', [
            'candidateDatas' =>  $candidateDatas,
            'candidateInformation' => $candidateInformation,
            'webSite'=>$webSite,
            'formationsInfo'=>$formationsInfo,
            'experiencesInfo'=>$experiencesInfo,
            'skillsInfo'=>$skillsInfo

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
