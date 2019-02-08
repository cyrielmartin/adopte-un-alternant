<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Entity\Article;
use App\Entity\Website;
use App\Entity\Mobility;

use App\Entity\Formation;
use App\Entity\VisitCard;
use App\Entity\Additional;
use App\Entity\Experience;
use App\Entity\IsCandidate;
use App\Entity\IsRecruiter;
use App\Entity\SearchCandidate;
use App\Entity\IsApprenticeship;
use App\Form\SearchCandidateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidat", name="candidates_")
 */
class CandidateController extends AbstractController
{
    /**
     * @Route("/liste", name="list")
     */
    public function showList(Request $request, EntityManagerInterface $em)
    {
        // J'utilise l'entity manager pour éviter de surcharger ma liste de paramètre en injection
        $visitCardRepo = $em->getRepository(VisitCard::class);
        $articleRepo = $em->getRepository(Article::class);

        /** 
         * Création d'un formulaire pour obtenir les critères de sélection du visiteur
         * Création d'un nouvel objet de SearchCandidate 
         * (entité custom créée pour filtrer les recherches mais qui n'existe pas en BDD)
        */
        $search = New SearchCandidate();
        $form = $this->createForm(SearchCandidateType::class, $search);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // je récupère tout ce qui a pu être coché
            $filters = $request->query->all();

            // S'il n'y avait qu'un type de filtre
            if(count($filters) === 1 )
            {
                $visitCards = $this->oneFilter($filters, $visitCardRepo);
            }
            // S'il y avait deux types de filtre
            elseif (count($filters) === 2)
            {
                $visitCards = $this->twoFilter($filters, $visitCardRepo);
            }
            // S'il y avait trois types de filtre ( soit tous )
            elseif (count($filters) === 3)
            {
                $visitCards = $this->allFilter($filters, $visitCardRepo);
            }
            // Si un petit malin a bidouillé l'inté
            else
            {
                $visitCards = $visitCardRepo->findAll();
            }
        } 
        else
        {
            $visitCards = $visitCardRepo->findAll();
        }
        
        $articles = $articleRepo->findAll();

        return $this->render('candidate/list.html.twig', [
            'visitCards'=>$visitCards,
            'articles'=>$articles,
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/{id}/profil", name="one")
    */
    public function showOne(EntityManagerInterface $em, $id)
    {
        $user = $this->getUser();
        $role = $user->getRole()->getCode();

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
        
        $candidateDatas= $isCandidateRepo->findOneBy(['user' => $id]);

        $isFavorite = false;

        if($role === 'ROLE_RECRUITER')
        {
            $favorites = $candidateDatas->getIsRecruiters();
            
            foreach($favorites as $favorite )
            {
                if($favorite->getUser()->getId() == $user->getId() )
                {
                    $isFavorite = true ;
                }
            }
        }
        //récupération de l'Id pour accéder aux visitCards
        $candidateId=$candidateDatas->getId();

        //création d'un requête join dans le fichier isRecruiterRepo pour récupérer les nombres de vue du candidat et les recruteurs ayant consulté le profil du candidat par Id candidat
        $viewsInfo = $isRecruiterRepo->findViewProfil($candidateId);

        $candidateInformation = $visitCardRepo->findOneBy(['isCandidate' => $candidateId]);

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

        return $this->render('candidate/one.html.twig', [
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
            'isFavorite' => $isFavorite,
        ]);
    }

    /** 
     * Fonction récupérant UN type de filtre ( skills ou departments ou awards )
     * et renvoyant un tableau contenant les cartes de visites répondant au filtre donné
    */
    private function oneFilter($filter, $visitCardRepo)
    {
        if (key($filter) === "skills")
        {
            $results = $visitCardRepo->findBySkill($filter['skills']);
        }
        elseif (key($filter) === "departments")
        {
            $results = $visitCardRepo->findByDepartment($filter['departments']);
        }
        elseif (key($filter) === "awards")
        {
            $results = $visitCardRepo->findByAward($filter['awards']);
        }
        else
        {
            $results = array();
        }

        return $results;
    }

    /** 
     * Fonction récupérant DEUX types de filtre parmis skills, departments et awards 
     * et renvoyant un tableau contenant les cartes de visites répondant aux filtre donné
    */
    private function twoFilter($filters, $visitCardRepo)
    {
        // Je récupère les index de filters pour avoir le nom des types de filtre donné
        foreach($filters as $key => $filter)
        {
            $filterNames[] = $key;
        }
        /**
         * Peu importe le nombre de filtre coché, les résultats sont toujours
         * récupérés d'après l'ordre d'affichage du form soit:
         * [0]skills
         * [1]departments ou [1]awards 
         * 
         * J'effectue donc mes tests en respectant cet ordre
         */

        // Si on a skills parmis les filtres
        if ($filterNames[0] === 'skills')
        {
            $resultFilters[] = $visitCardRepo->findBySkill($filters['skills']);

            // ET si on a departments
            if ($filterNames[1] === 'departments')
            {
                $resultFilters[] = $visitCardRepo->findByDepartment($filters['departments']);
            }
            // OU ET si on a awards
            elseif ($filterNames[1] === 'awards')
            {
                $resultFilters[] = $visitCardRepo->findByAward($filters['awards']);
            }
        }

        /** 
         * Si on a pas skills parmis les choix , comme il n'y a que 3 choix 
         * possible on peu donc en déduire sans trop de risque qu'on aura
         * departments et awards
         * */ 
        elseif ($filterNames[0] === 'departments' )
        {
            $resultFilters[] = $visitCardRepo->findByDepartment($filters['departments']);

            $resultFilters[] = $visitCardRepo->findByAward($filters['awards']);
        }

        // on déclare le tableau de résultat
        $results = array();

        // Pour chaque candidats récupéré dans le premier filtre
        foreach($resultFilters[0] as $currentFirstFilter)
        {
            // On compare avec les candidats récupéré dans le deuxième filtre
            foreach($resultFilters[1] as $currentSecondFilter)
            {
                // si un candidat match sur les deux filtres
                if($currentFirstFilter->getId() == $currentSecondFilter->getId())
                {
                    // on l'enregistre dans le tableau de résultats
                    $results[] = $currentFirstFilter;
                }
            }
        }

        return $results;
    }

    /** 
     * Fonction récupérant TOUT les types de filtre, soit : skills, departments et awards 
     * et renvoyant un tableau contenant les cartes de visites répondant aux 3 filtres
    */
    private function allFilter($filters, $visitCardRepo)
    {
        $resultFilters[] = $visitCardRepo->findBySkill($filters['skills']);
        $resultFilters[] = $visitCardRepo->findByDepartment($filters['departments']);
        $resultFilters[] = $visitCardRepo->findByAward($filters['awards']);

        // On déclare le tableau de résultat
        $results = array();

        // Pour chaque candidats récupéré dans le premier filtre
        foreach($resultFilters[0] as $currentFirstFilter)
        {
            // On compare avec les candidats récupéré dans le deuxième filtre
            foreach($resultFilters[1] as $currentSecondFilter)
            {
                // Si un candidat match sur les deux premiers filtres
                if($currentFirstFilter->getId() == $currentSecondFilter->getId())
                {
                    // Alors on vérifie qu'il corresponde au troisème filtre
                    foreach($resultFilters[2] as $currentThirdFilter)
                    {
                        // S'il correspondent
                        if ($currentSecondFilter->getId() == $currentThirdFilter->getId())
                        {
                            // On l'enregistre dans le tableau de résultats
                            $results[] = $currentFirstFilter;
                        }
                    }
                }
            }
        }

        return $results;
    }

}
