<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\VisitCard;
use App\Entity\SearchCandidate;
use App\Form\SearchCandidateType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CandidateController extends AbstractController
{
    /**
     * @Route("/candidates", name="candidates_list")
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
         * Peut importe le nombre de filtre coché, les résultats sont toujours
         * récupéré d'après l'ordre d'affichage du form soit:
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
