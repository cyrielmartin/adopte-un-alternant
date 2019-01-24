<?php

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\VisitCardRepository;
use App\Repository\ArticleRepository;

class CandidateController extends AbstractController
{
    /**
     * @Route("/candidates", name="candidates_list")
     */
    public function showList(VisitCardRepository $visitCardRepo, ArticleRepository $articleRepo)
    {

        $visitCards = $visitCardRepo->findAll();
        $articles = $articleRepo->findAll();
        
        return $this->render('candidate/list.html.twig', [
            'visitCards'=>$visitCards,
            'articles'=>$articles
        ]);
    }

}
