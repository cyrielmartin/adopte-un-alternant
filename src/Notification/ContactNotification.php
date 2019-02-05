<?php
namespace App\Notification;

use App\Entity\Email;
use Twig\Environment;

class ContactNotification{

    /**
     * @var \Swift_Mailer
     */

     private $mailer;

     /**
      * @var Environment
      */
    
      private $renderer;

    
    //reçoit en paramètre le Swiftmailer et environnement pour le formatage
    public function __contruct(\Swift_Mailer $mailer, Environment $renderer){

        $this->mailer =$mailer;
        $this->renderer=$renderer;

    }
    
    public function notify(Email $email){
        $message = (new \Swift_Message($email->getRecruiter().' veut entrer en contact avec vous'))
//
        ->setFrom($email->getRecruiterEmail())
        ->setTo('aude.millequant@wanadoo.fr')
        ->setReplyTo($email->getRecruiterEmail())
        ->setBody($this->renderer->render('recruiter/profile/email_send.html.twig',[
            'email'=>$email,
        ]), 'text/html');

       return $this->mailer->send($message);
    
    }
}