<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;

class CandidateController extends AbstractController
{
    /**
     * @Route("/candidate", name="candidate")
     */
    public function index(UserRepository $userRepo)
    {
        $users= $userRepo->findAll();
        
        return $this->render('candidate/index.html.twig', [
            'users'=>$users,
        ]);
    }
}
