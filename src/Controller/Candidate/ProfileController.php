<?php
namespace App\Controller\Candidate;

namespace App\Controller\Candidate;

use App\Entity\User;
use App\Form\UserEditType;
use App\Repository\SkillRepository;
use App\Repository\WebsiteRepository;
use App\Repository\MobilityRepository;
use App\Repository\FormationRepository;
use App\Repository\VisitCardRepository;
use App\Repository\AdditionalRepository;
use App\Repository\ExperienceRepository;
use App\Repository\IsCandidateRepository;
use App\Repository\IsRecruiterRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/candidat", name="candidate_")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function show(EntityManagerInterface $em, IsCandidateRepository $isCandidateRepo, IsRecruiterRepository $isRecruiterRepo, VisitCardRepository $visitCardRepo, WebsiteRepository $webSiteRepo, FormationRepository $formationRepo, ExperienceRepository $experienceRepo, SkillRepository $skillRepo, AdditionalRepository $additionalRepo, MobilityRepository $mobilityRepo)
    {

        // Affiche le profil du user candidat à l'alternance
        // Pas de form ici ( seulement de la récupèration d'info pour affichage )
        $user = $this->getUser();
        $userId= $user->getId();
        
        $candidateDatas= $isCandidateRepo->findOneByuser($userId);

        //récupération de l'Id pour accéder aux visitCards
        $candidateId=$candidateDatas->getId();

        //création d'un requête join dans le fichier isRecruiterRepo pour récupérer les nombres de vue du candidat et les recruteurs ayant consulté le profil du candidat par Id candidat
        $viewsInfo = $isRecruiterRepo ->findViewProfil($candidateId);

        $candidateInformation = $visitCardRepo->findOneByIsCandidate($candidateId);

        //récupération de l'Id de la visitCard pour accéder aux metatables
        $visitCardId = $candidateInformation->getId();
       
        $webSites = $webSiteRepo->findByVisitCard($visitCardId);
       
        $formationsInfo=$formationRepo->findByVisitCard($visitCardId);

        $formationsInfo=$formationRepo->findByVisitCard($visitCardId);

        $experiencesInfo =$experienceRepo->findByVisitCard($visitCardId);


        //création d'un requête join dans le fichier skill repo pour récupérer les compétences par Id de visitCard
        $skillsInfo = $skillRepo ->findByVisitCard($visitCardId);

        $additionalsInfo = $additionalRepo ->findByVisitCard($visitCardId);

        //création d'un requête join dans le fichier mobilityRepo pour récupérer les mobilités du candidat par Id de visitCard
        $mobilitiesInfo = $mobilityRepo ->findByVisitCard($visitCardId);

        return $this->render('candidate/profile/profile.html.twig', [
            'candidateDatas' =>  $candidateDatas,
            'candidateInformation' => $candidateInformation,
            'webSites'=>$webSites,
            'formationsInfo'=>$formationsInfo,
            'experiencesInfo'=>$experiencesInfo,
            'skillsInfo'=>$skillsInfo,
            'additionalsInfo'=>$additionalsInfo,
            'mobilitiesInfo'=>$mobilitiesInfo,
            'visitCardId'=>$visitCardId,
            'viewsInfo'=>$viewsInfo

        ]);
    }

    /**
     * @Route("/information-personelle", name="informations")
     */
    public function userInfoEdit(Request $request, UserPasswordEncoderInterface $encoder)
    {
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
            
            return $this->redirectToRoute('candidate_profile');
        }
        return $this->render('candidate/profile/user_info.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    // pas de suppression possible au niveau des info perso, seulement de la modification

}
