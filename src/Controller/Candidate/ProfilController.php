<?php

namespace App\Controller\Candidate;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\IsCandidateRepository;

/**
 * @Route("/candidat", name="candidate_")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/profil/{id}", name="profil")
     */
    public function show(User $user, IsCandidateRepository $isCandidateRepo)
    {
        $userId= $user->getId();
        
        $candidateDatas= $isCandidateRepo->findOneByuser($userId);
        //dd($candidateDatas);

     
        // Affiche le profil du user 
        // Pas de form ici ( seulement de la récupèration d'info pour affichage )

        return $this->render('candidate/profil/profil.html.twig', [
            'candidateDatas' =>  $candidateDatas,
        ]);
    }

    /**
     * @Route("/information-personelle", name="informations")
     */
    public function userInfoEdit()
    {
        // Affiche / traite le(s) formulaire(s) réunissant les infos personelles propre à TOUT les user (nom prénom email mot de passe)
        // ainsi que les info complémentaires propre au role candidat  (telephone picture)
        
        return $this->render('candidate/profil/user_info.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    // pas de suppression possible au niveau des info perso, seulement de la modification

}
