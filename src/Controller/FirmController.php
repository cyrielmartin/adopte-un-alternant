<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FirmController extends AbstractController
{
    /**
     * @Route("/firm", name="firm")
     */
    public function index()
    {
        return $this->render('firm/index.html.twig', [
            'controller_name' => 'FirmController',
        ]);
    }
}
