<?php

namespace App\Controller\Message;

use App\Entity\Message;
use App\Entity\IsCandidate;
use App\Entity\IsRecruiter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/message", name="message_")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/afficher", name="show")
     */
    public function show(Request $request)
    {
        $user = $this->getUser();
        $role = $user->getRole()->getCode();

        if($role === 'ROLE_CANDIDATE')
        {
            // je récupère sa fiche candidat
            $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
            $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);
            $messages = $candidate->getMessages();
        }
        else if ($role === 'ROLE_RECRUITER')
        {
            // je récupère sa fiche recruteur
            $recruiterRepo = $this->getDoctrine()->getRepository(IsRecruiter::class);
            $recruiter = $recruiterRepo->findOneBy(['user' => $user->getId()]);
            $messages = $recruiter->getMessages();
        }
        
        foreach($messages as $key => $msg)
        {
            if($role === 'ROLE_CANDIDATE')
            {
                // je récupère l'id du recruteur 
                $contactId = $msg->getIsRecruiter()->getId();
                $contactList[$contactId] = $msg->getIsRecruiter();
            }
            else if ($role === 'ROLE_RECRUITER')
            {
                // je récupère l'id du candidat
                $contactId = $msg->getIsCandidate()->getId();
                $contactList[$contactId] = $msg->getIsCandidate();
            }
        }

        return $this->render('message/message.html.twig', [
            'contacts' => $contactList,
        ]);
    }

    /**
     * @Route("/recover", name="recover")
     */
    public function recover(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $role = $user->getRole()->getCode();

        if($role === 'ROLE_CANDIDATE')
        {
            // je récupère sa fiche candidat
            $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
            $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);
            $messages = $candidate->getMessages();
        }
        else if ($role === 'ROLE_RECRUITER')
        {
            // je récupère sa fiche recruteur
            $recruiterRepo = $this->getDoctrine()->getRepository(IsRecruiter::class);
            $recruiter = $recruiterRepo->findOneBy(['user' => $user->getId()]);
            $messages = $recruiter->getMessages();
        }
        
        // je récupère l'id de la conversation selectionné
        $select = $request->query->get('select');
        // je le transform en int
        $select = intval($select);

        // si l'utilisateur a selectionné une conversation
        if(!empty($select))
        {
            // j'enregistre en session l'id de la personne dont la conversation a été selectionné
            $this->get('session')->set('talkTo', $select);
        }
        else
        {
            // j'enregistre une chaine vide
            $this->get('session')->set('talkTo', '');
            $response = ['fail','Aucun contact séléctionné'];
        }

        $sortMessages = array();
        
        foreach($messages as $key => $msg)
        {
            if($role === 'ROLE_CANDIDATE')
            {
                // je récupère l'id du recruteur 
                $contactId = $msg->getIsRecruiter()->getId();
                $contactList[$contactId] = $msg->getIsRecruiter();
            }
            else if ($role === 'ROLE_RECRUITER')
            {
                // je récupère l'id du candidat
                $contactId = $msg->getIsCandidate()->getId();
                $contactList[$contactId] = $msg->getIsCandidate();
            }

            if($contactId === $select)
            {
                $sortMessages[] = [
                    'content' => $msg->getContent(),
                    'sendBy' => $msg->getSendBy(),
                    'sendAt' => $msg->getSendAt()->format('d/m/Y H:m'),
                ]; 
            }
        }

        $response = ['success', $sortMessages];

        // je retourne les résultat en format json
        return new JsonResponse($response);
    }


    /**
     * @Route("/send", name="send")
     */
    public function send(Request $request, EntityManagerInterface $em)
    {
        // je récupère en session l'id précédement enregistré
        $talkTo = $this->get('session')->get('talkTo');
        // et l'id envoyé dans la requête
        $select = $request->request->get('select');
        $select = intval($select);
        // je récupère le contenu de la réponse
        $response = $request->request->get('response');
        $response = trim(strip_tags($response));
        $error = false;
        
        // si le candidat n'avais selectionné aucune conversation auparavent
        if(empty($talkTo))
        {
            $error = true;
            $toReturn ='Une erreur est survenue';
        }
        // si la conversation selectionné auparavent n'a rien à voir avec l'id envoyé
        else if($talkTo !== $select)
        {
            $error = true;
            $toReturn ='Une erreur est survenue';
        }
        // si le message est vide
        else if (empty($response))
        {
            $error = true;
            $toReturn = 'Vous ne pouvez pas envoyer de message vide';
        }
        // je continu seulement s'il n'y a pas eu d'erreur
        if (!$error)
        {
            $user = $this->getUser();
            $role = $user->getRole()->getCode();

            if($role === 'ROLE_CANDIDATE')
            {
                // je récupère la fiche du candidat connecté
                $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
                $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);

                // je récupère la fiche recruteur du recruteur à qui envoyer le message
                $recruiterRepo = $this->getDoctrine()->getRepository(IsRecruiter::class);
                $recruiter = $recruiterRepo->findOneBy(['id' => $select]);

                // si recruteur inexistant
                if (empty($recruiter))
                {
                    $error = true;
                    $toReturn ='Une erreur est survenue';
                }
            }
            else if ($role === 'ROLE_RECRUITER')
            {
                // je récupère la fiche recruteur du recruteur à qui envoyer le message
                $recruiterRepo = $this->getDoctrine()->getRepository(IsRecruiter::class);
                $recruiter = $recruiterRepo->findOneBy(['user' => $user->getId()]);
                
                // je récupère la fiche du candidat connecté
                $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
                $candidate = $candidateRepo->findOneBy(['id' => $select]);

                // si candidat inexistant
                if (empty($candidate))
                {
                    $error = true;
                    $toReturn ='Une erreur est survenue';
                }
            }

            // je continue seulement s'il n'y a pas eu d'erreur
            if(!$error)
            {
                $msg = new Message();
                $msg
                    ->setIsRecruiter($recruiter)
                    ->setIsCandidate($candidate)
                    ->setContent($response)
                    ->setSendAt(new \DateTime('NOW'));
                
                if($role === 'ROLE_CANDIDATE')
                {
                    $msg->setSendBy(1);
                }
                else if($role === 'ROLE_RECRUITER')
                {
                    $msg->setSendBy(0);
                }
                
                $em->persist($msg);
                $em->flush();
            }
        }

        if($error)
        {

            return new JsonResponse(['fail', $toReturn]);
        }

        return new JsonResponse(['success']);
    }
}
