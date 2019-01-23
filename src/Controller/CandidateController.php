<?php

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\VisitCardRepository;
use App\Repository\ArticleRepository;

class CandidateController extends AbstractController
{
    /**
     * @Route("/candidates", name="candidates_index")
     */
    public function index(VisitCardRepository $visitCardRepo, ArticleRepository $articleRepo)
    {
        
        
        $visitCards = $visitCardRepo->findAll();
        $articles = $articleRepo->findAll();
        //dd($visitCard);
        //dd($articles);
        
        return $this->render('candidate/index.html.twig', [
            //'candidates'=>$candidates,
            'visitCards'=>$visitCards,
            'articles'=>$articles

        ]);
    }

}
