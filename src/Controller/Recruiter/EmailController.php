<?php

namespace App\Controller\Recruiter;

use App\Entity\IsCandidate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

        // je récupère la fiche  candidat du candidat que le recruteur cherche à contacter
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['id' => $id]);
        //dd($candidate);


        $name =$email= $objet=NULL;

        $form =$this->createFormBuilder()
            ->add('objet', TextType::class, [
                'placeholder' => 'Votre profil nous intéresse',
                
            ])
            ->add('text', TextType::class, [
                'placeholder' => 'Nous souhaierions entrer en contact avec vous pour éventuellement développer des projets avec vous',
                
            ])
            ->getForm();
        
        $form->handleRequest($request);


        //$message = (new \Swift_Message($user->getLastName().' veut entrer en contact avec vous'))
        //->setFrom($user->getemail())
        //->setTo('aude.millequant@wanadoo.fr')
        //->setBody(
        //    $this->renderView(
        //        // templates/emails/registration.html.twig
        //        'recruiter/profile/preformated_send_email.html.twig',
        //        ['name' => $id,
        //        'user'=>$user,]
        //    ),
        //    'text/html'
        //);
//
        //$mailer->send($message);
//
        //return $this->redirectToRoute('candidates_one', ['id' => $id]);

        return $this->render('recruiter/profile/preformated_send_email.html.twig', [
            'form' => $form->createView(),
            'name'=>$name,
            'email'=>$email,
            'objet'=>$objet,
            'candidate'=>$candidate

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
