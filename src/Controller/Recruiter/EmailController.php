<?php

namespace App\Controller\Recruiter;

use App\Entity\User;
use App\Entity\Email;
use App\Form\EmailType;
use App\Entity\IsCandidate;
use App\Repository\UserRepository;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/recruteur/email", name="email_")
 */
class EmailController extends AbstractController
{
    /**
     * @Route("/{id}/envoyer", name="send")
     */
    public function send($id, \Swift_Mailer $mailer, Request $request)
    {
        
        /** 
         * Comme le bouton "envoyer un mail en 1 clic" se situe dans la page de profil publique d'un candidat, il faudra rediriger 
         * vers celle-ci à l'aide de l'id fourni.
         * 
         * Penser à vérifier que l'id est bien l'id d'un candidat existant avant de faire toute action
         * si id non existant : return $this->redirectToRoute('candidates_list');
         * */ 

        $user = $this->getUser();
        $userName=$user->getLastName();
        $userEmail=$user->getEmail();
        //dd($userName);
        //dd($userEmail);

        // je récupère la fiche  candidat du candidat que le recruteur cherche à contacter
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $id]);
        $candidateUserId=$candidate->getUser('id');
        $userRepo= $this->getDoctrine()->getRepository(User::class);
        $candidateUserInfo=$userRepo->findOneBy(['id'=>$id]);
        
        $candidateEmail=$candidateUserInfo->getEmail();
        dump($candidateEmail);
        dump($candidateUserInfo);
        //dd($candidateUserId);
        

        /** 
         * Création d'un formulaire de contact pour envoyer un mail au candidat sélectionné
         * Création d'un nouvel objet Email.php
         * (entité custom créée stocker les mails mais qui n'existe pas en BDD donc je n'ai pas fais php bin/console make:entity)
        */
        $email = New Email();
        

        $form = $this->createForm(EmailType::class, $email);
        $email->setRecruiter($userName);
        $email->setRecruiterEmail($userEmail);
        $email->setCandidateEmail($candidateEmail);
        //dd($email);
        $form->handleRequest($request);
        //$message=[];
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $email=$form->getData();
            //dd($email);
            // création d'une classe pour grer l'envoie de mail (dans App\notification)
            $this->addFlash('success', 'Votre email a bien été envoyé');
            //$notification->notify($email);
            $message = (new \Swift_Message($email->getRecruiter().' veut entrer en contact avec vous'))
            //
                    ->setFrom('adoptealternant@gmail.com')
                    ->setTo($email->getCandidateEmail())
                    ->setReplyTo($email->getRecruiterEmail())
                    ->setBody($this->renderView('recruiter/profile/email_send.html.twig',[
                        'email'=>$email,
                    ]), 'text/html');
            
            $mailer->send($message);
            
            

            return $this->redirectToRoute('candidates_one', ['id' => $id]);
            
            //dd($email);

            
            
       
        //$message = (new \Swift_Message($user->getLastName().' veut entrer en contact avec vous'))
        //->setFrom($user->getemail())
        //->setTo('aude.millequant@wanadoo.fr')
        //->setReplyTo($user->getemail())
        //->setBody(
        //    $this->renderView(
        //         
        //     'recruiter/profile/email.html.twig',
        //       ['email' => $email,
        //       ]
        //    ),
        //    'text/html'
        //);
        //$mailer->send($message);
//
        
//
            return $this->redirectToRoute('candidates_list');
        }

        
        //return $this->redirectToRoute('candidates_one', ['id' => $id]);

        return $this->render('recruiter/profile/email.html.twig', [
            'form' => $form->createView(),
            

            ]);
    }

    /**
    * @Route("/personnaliser", name="edit")
    */
    public function edit( \Swift_Mailer $mailer)
    {
        /** 
         * Permet de personnaliser le mail du recruteur connecté
         * Pas besoin de récupérer l'id du mail, il fait partie de la fiche isRecruiter et il n'en possède qu'un seul
        */


        

        return $this->render('recruiter/profile/email.html.twig', [
            
        ]);
    }

    /** 
    * Pas de méthode add : le recruteur n'a qu'un seul et unique "format" de mail à envoyer au candidat
    * Pas de méthode delete : il doit toujours y avoir un mail à envoyer, si ce n'est pas un mail custom alors ça sera un mail par défaut.
    */
}
