<?php

namespace App\Controller\Candidate;

use App\Entity\Message;
use App\Entity\IsCandidate;
use App\Entity\IsRecruiter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidate/message", name="message_")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/afficher", name="show_all")
     */
    public function showAll(Request $request)
    {
        $user = $this->getUser();
        // je récupère sa fiche candidat
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);
        $messages = $candidate->getMessages();
        
        // je récupère l'id du recruteur dont la conversation à été choisi
        $select = $request->query->get('recruiter');
        // je le transform en int
        $select = intval($select);

        // si le candidat a selectionné une conversation
        if(!empty($select))
        {
            // j'enregistre en session l'id du recruteur dont la conversation a été selectionné
            $this->get('session')->set('talkTo', $select);
        }
        else
        {
            // j'enregistre une chaine vide
            $this->get('session')->set('talkTo', '');
        }

        $sortMessages = array();
        
        foreach($messages as $key => $msg)
        {
            // je récupère l'id du recruteur
            $recruiterId = $msg->getIsRecruiter()->getId();
            // je me sert de l'id ( qui est unique ) pour trier mes messages par conversation
            $recruiterList[$recruiterId] = $msg->getIsRecruiter();

            if($recruiterId === $select)
            {
                $sortMessages[] = $msg;
            }
        }

        return $this->render('candidate/message/message.html.twig', [
            'recruiter_select' => $select,
            'messages' => $sortMessages,
            'recruiters' => $recruiterList,
        ]);
    }

    /**
     * @Route("/{id}/envoyer", name="send")
     */
    public function send(Request $request, $id, EntityManagerInterface $em)
    {
        // je récupère en session l'id du recruteur précédement enregistré
        $talkTo = $this->get('session')->get('talkTo');
        $id = intval($id);
        // je récupère le contenu de la réponse
        $response = $request->request->get('response');
        $response = trim(strip_tags($response));
        $error = false;
        
        // si le candidat n'avais selectionné aucune conversation auparavent
        if(empty($talkTo))
        {
            $error = true;
        }
        // si la conversation selectionné auparavent n'a rien à voir avec l'id envoyé
        else if($talkTo !== $id)
        {
            $error = true;
        }
        // si le message est vide
        else if (empty($response))
        {
            $error = true;
        }
        // je continu seulement s'il n'y a pas eu d'erreur
        if (!$error)
        {
            $this->getUser();

            $user = $this->getUser();
            // je récupère la fiche du candidat connecté
            $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
            $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);
            
            // je récupère la fiche recruteur du recruteur à qui envoyer le message
            $recruiterRepo = $this->getDoctrine()->getRepository(IsRecruiter::class);
            $recruiter = $recruiterRepo->findOneBy(['id' => $id]);

            // s'il y a eu une erreur --> return + flash message
            if (empty($recruiter))
            {
                $error = true;
            }

            // je continue seulement s'il n'y a pas eu d'erreur
            if(!$error)
            {
                $msg = new Message();
                $msg
                    ->setIsRecruiter($recruiter)
                    ->setIsCandidate($candidate)
                    ->setContent($response)
                    ->setSendBy(1)
                    ->setSendAt(new \DateTime('NOW'));
                $em->persist($msg);
                $em->flush();
            }
        }

        if($error)
        {
            $this->addFlash('danger', 'Une erreur est survenue lors de l\'envoi.');
            return $this->redirectToRoute('message_show_all');
        }

        return $this->redirectToRoute('message_show_all', ['recruiter' => $id]);
    }
}
