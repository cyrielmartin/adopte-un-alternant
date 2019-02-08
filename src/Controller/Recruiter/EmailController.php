<?php

namespace App\Controller\Recruiter;

use App\Entity\User;
use App\Entity\Email;
use App\Form\EmailType;
use App\Entity\IsCandidate;
use App\Entity\IsRecruiter;
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
      
        // je récupere la fiche recruteur afin d'accéder aux informations de l'entreprise
        $recruiterRepo = $this->getDoctrine()->getRepository(IsRecruiter::class);
        $recruiter = $recruiterRepo->findOneBy(['user' => $user->getId()]);
        $recruiterFirm=$recruiter->getCompanyName();
        

        // je récupère la fiche  candidat du candidat que le recruteur cherche à contacter
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $id]);
        
        
        
        if(!empty ($candidate))
        {
            $userRepo= $this->getDoctrine()->getRepository(User::class);
            $candidateUserInfo=$userRepo->findOneBy(['id'=>$id]);
            
            $candidateEmail=$candidateUserInfo->getEmail();
            
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
            $email->setCompanyName($recruiterFirm);
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) 
            {
                $email=$form->getData();
                
                
                
                $message = (new \Swift_Message($email->getRecruiter().' veut entrer en contact avec vous'))
                        ->setFrom('adoptealternant@gmail.com')
                        ->setTo($email->getCandidateEmail())
                        ->setReplyTo($email->getRecruiterEmail())
                        ->setBody($this->renderView('recruiter/profile/email_send.html.twig',[
                            'email'=>$email,
                        ]), 'text/html');
                        
                $mailer->send($message);
                        

                $this->addFlash('notice', 'Votre email a bien été envoyé');
                        

                return $this->redirectToRoute('candidates_list');
                        
                               
                        
            } 
        } 
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue.');
            return $this->redirectToRoute('candidates_list');

        }

       

        return $this->render('recruiter/profile/email.html.twig', [
            'form' => $form->createView(),
            

            ]);
    }

   
}
