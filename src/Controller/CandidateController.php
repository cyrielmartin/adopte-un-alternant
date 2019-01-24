<?php

namespace App\Controller;


use App\Entity\VisitCard;
use App\Form\SearchCandidateType;

use App\Repository\SkillRepository;
use App\Repository\ArticleRepository;
use App\Repository\VisitCardRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\SearchCandidate;

class CandidateController extends AbstractController
{
    /**
     * @Route("/candidates", name="candidates_list")
     */
    public function showList(Request $request, VisitCardRepository $visitCardRepo, ArticleRepository $articleRepo, SkillRepository $skillRepo)
    {
        //j'essaie de créer un formulaire pour obtenir les critères de sélection du visiteur
        //JE crée un nouvel objet de SearchCandidate (entité crééée mais qui n'est pas en BDD)
        $search = New SearchCandidate();
        $form = $this->createForm(SearchCandidateType::class, $search);
        $form->handleRequest($request);
        
        $visitCards = $visitCardRepo->findAllSearchCandidateQuery();
        //dd($visitCards);
        
        //requeste sur la sélection
        $articles = $articleRepo->findAll();
        $skills = $skillRepo->findAll();
       
        
        return $this->render('candidate/list.html.twig', [
            'visitCards'=>$visitCards,
            'articles'=>$articles,
            'skills'=>$skills,
            //'searchCandidates'=>$searchCandidates,
            'form' => $form->createView(),
        ]);
    }

}
