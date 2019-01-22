<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
<<<<<<< HEAD
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
=======
     * @Route("/", name="home")
     */
    public function index()
    {
        
        return $this->render('home/index.html.twig', [
>>>>>>> origin/CreateInteAccueil
        ]);
    }
}
