<?php

namespace App\Controller\Chat;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/chat", name="chat_")
 */

class ChatController extends AbstractController
{
    
    
    /**
     * @Route("/", name="chat")
     */
    public function index()
    {
        return $this->render('chat/chat.html.twig', [
            'ws_url' => 'localhost:8080',
        ]);
    }
}
