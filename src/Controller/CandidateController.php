<?php

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\VisitCardRepository;

class CandidateController extends AbstractController
{
    /**
     * @Route("/entreprise", name="entreprise_index")
     */
    public function index(VisitCardRepository $visitCardRepo)
    {
        
        //$candidates= $isCandidateRepo->findAll();
        $visitCards = $visitCardRepo->findAll();
        //dd($visitCard);
        
        return $this->render('candidate/index.html.twig', [
            //'candidates'=>$candidates,
            'visitCards'=>$visitCards
        ]);
    }

     /**
     * @Route("/entreprise/candidates", name="candidates_list")
     */
    public function showCandidate (VisitCardRepository $visitCardRepo)
    {
        
        //$candidates= $isCandidateRepo->findAll();
        $visitCards = $visitCardRepo->findAll();
        //dd($visitCard);
        
        return $this->render('candidate/show.html.twig', [
            //'candidates'=>$candidates,
            'visitCards'=>$visitCards
        ]);
    }
}
