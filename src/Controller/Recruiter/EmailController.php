<?php

namespace App\Controller\Recruiter;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/recruteur/email", name="email_")
 */
class EmailController extends AbstractController
{
    /**
     * @Route("/{id}/envoyer", name="send")
     */
    public function send($id)
    {
        /** 
         * Comme le bouton "envoyer un mail en 1 clic" se situe dans la page de profil publique d'un candidat, il faudra rediriger 
         * vers celle-ci à l'aide de l'id fourni.
         * 
         * Penser à vérifier que l'id est bien l'id d'un candidat existant avant de faire toute action
         * si id non existant : return $this->redirectToRoute('candidates_list');
         * */ 
        return $this->redirectToRoute('candidates_one', ['id' => $id]);
    }

    /**
    * @Route("/personnaliser", name="edit")
    */
    public function edit()
    {
        /** 
         * Permet de personnaliser le mail du recruteur connecté
         * Pas besoin de récupérer l'id du mail, il fait partie de la fiche isRecruiter et il n'en possède qu'un seul
        */

        return $this->render('recruiter/profile/email.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }

    /** 
    * Pas de méthode add : le recruteur n'a qu'un seul et unique "format" de mail à envoyer au candidat
    * Pas de méthode delete : il doit toujours y avoir un mail à envoyer, si ce n'est pas un mail custom alors ça sera un mail par défaut.
    */
}
