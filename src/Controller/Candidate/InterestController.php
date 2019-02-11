<?php

namespace App\Controller\Candidate;

use App\Form\AssetType;
use App\Entity\VisitCard;
use App\Entity\Additional;
use App\Entity\IsCandidate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidat/centre-d-interet", name="interest_")
 */
class InterestController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add(Request $request)
    {
        $user = $this->getUser();
        // je récupère sa fiche candidat
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);
        // récupération de la carte de visite du candidat connecté
        $visitCardRepo = $this->getDoctrine()->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);
        $visitCardId = $visitCard->getId();
        
        //je récupére les asserts déjà enregistrés
        //$asserts = $visitCard ->getAdditionals();
        $additionalRepo = $this->getDoctrine()->getRepository(Additional::class);
        $asserts = $additionalRepo ->findBy(['visitCard' => $visitCardId, 'typeInfo'=>'interest']);
        //dump($asserts);
        $nbAsserts=count($asserts);
        //dump($nbAsserts);

        if($nbAsserts < 5){
        
            $interest= new Additional();
            
            

            $form = $this->createForm(AssetType::class, $interest);
            

            $form->handleRequest($request);
           

    
            if ($form->isSubmitted() && $form->isValid()) 
            { //dd($request);
            // ajout des info nécessaire à l'enregistrement
            $asset = $form->getData();
            
            $asset->setVisitCard($visitCard);

            // on sait qu'il s'agit d'un Type info "interest", on l'enregistre par défaut

            $asset ->setTypeInfo('interest');
            //$asset1 ->setTypeInfo('assert');



            $em = $this->getDoctrine()->getManager();

            // enregistrement en bdd ( par un effet "cascade", le website sera enregistré aussi )
            $em->persist($asset);
            $em->flush($asset);
            

            return $this->redirectToRoute('candidate_profile');
            }
            
        }else {
            $this->addFlash('danger', 'Vous avez déjà 5 centres d\'intérêt, vous ne pouvez pas en ajouter d\'avantage');
            return $this->redirectToRoute('candidate_profile');
        }
        
        
        return $this->render('candidate/profile/interest.html.twig', [
            'form' => $form->createView(),
            'tab_type' => 'Ajouter',
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit(Request $request, $id, EntityManagerInterface $em)
    {
        $user = $this->getUser();

        // je récupère sa fiche candidat
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);

        // récupération de la carte de visite du candidat connecté
        $visitCardRepo = $em->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);

        // je récupère l'atout qui doit être mise à jours
        $additionalRepo = $this->getDoctrine()->getRepository(Additional::class);
        $additional = $additionalRepo->findOneBy(['visitCard' => $visitCard->getId(), 'id' => $id]);

        // si cette expérience appartient bien au candidat connecté
        if(!empty($additional))
        {
            $form = $this->createForm(AssetType::class, $additional);
            $form->handleRequest($request);

        
            if ($form->isSubmitted() && $form->isValid())
            { 
               
            
                // enregistrement en bdd
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Votre centre d\'intérêt a bien été modifié'
                );
                
                return $this->redirectToRoute('candidate_profile');
            }
        }
        // si cette formation n'appartient pas au user connecté
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue');
            
            return $this->redirectToRoute('candidate_profile');
            
        }
        
        return $this->render('candidate/profile/interest.html.twig', [
            'form'=>$form->createView(),
            'tab_type' => 'Modifier',
        ]);
    }

    /**
     * @Route("/{id}/supprimer", name="delete")
     */
    public function delete($id)
    {
        // je récupère le user
        $user = $this->getUser();
        // je récupère sa fiche candidat
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);
        //dump($candidate);
        // je récupère la carte de visite du candidat
        $visitCardRepo = $this->getDoctrine()->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);
        $visitCardId =$visitCard->getId();
        //dump($visitCard);
        //dump($visitCardId);
        // je récupère le site qui doit être supprimé
        $additionalRepo = $this->getDoctrine()->getRepository(Additional::class);
        $additionalToDelete = $additionalRepo->findOneBy(['id' => $id, 'visitCard' => $visitCard->getId()]);
        
       // si l'experience appartient bien au user alors websiteToDelete n'est pas vide
        if(!empty($additionalToDelete))
        {
            $em = $this->getDoctrine()->getManager();
            // je la supprime
            $em->remove($additionalToDelete);
            $em->flush();

            $this->addFlash('notice', 'Votre atout a bien été supprimé.');
        }
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue lors de la suppression.');
        }
        
        return $this->redirectToRoute('candidate_profile');
    }
}