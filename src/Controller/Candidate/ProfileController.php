<?php
namespace App\Controller\Candidate;

namespace App\Controller\Candidate;

use App\Entity\User;
use App\Entity\Skill;
use App\Entity\Website;
use App\Entity\Mobility;
use App\Entity\Formation;
use App\Entity\VisitCard;
use App\Entity\Additional;
use App\Entity\Experience;
use App\Entity\IsApprenticeship;
use App\Form\UserEditType;
use App\Entity\IsCandidate;
use App\Entity\IsRecruiter;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/profil", name="profile")
     */
    public function show(EntityManagerInterface $em)
    {
        $isCandidateRepo = $em->getRepository(IsCandidate::class);
        $isRecruiterRepo = $em->getRepository(IsRecruiter::class);
        $isApprenticeshipRepo = $em->getRepository(IsApprenticeship::class);
        $visitCardRepo = $em->getRepository(VisitCard::class);
        $webSiteRepo = $em->getRepository(Website::class);
        $formationRepo = $em->getRepository(Formation::class);
        $experienceRepo = $em->getRepository(Experience::class);
        $skillRepo = $em->getRepository(Skill::class);
        $additionalRepo = $em->getRepository(Additional::class);
        $mobilityRepo = $em->getRepository(Mobility::class);

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

        $apprenticeshipsInfo = null;

        foreach($formationsInfo as $formation)
        {
            if($formation->getStatus() === 2)
            {
                $apprenticeshipsInfo = $isApprenticeshipRepo->findOneBy(['formation' => $formation->getId()]);
            }
        }

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
            'apprenticeshipsInfo' => $apprenticeshipsInfo,
            'experiencesInfo'=>$experiencesInfo,
            'skillsInfo'=>$skillsInfo,
            'additionalsInfo'=>$additionalsInfo,
            'mobilitiesInfo'=>$mobilitiesInfo,
            'visitCardId'=>$visitCardId,
            'viewsInfo'=>$viewsInfo,
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
