<?php

namespace App\Controller\Candidate;

use App\Form\AssetType;
use App\Entity\VisitCard;
use App\Entity\Additional;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidat/savoir-etre", name="asset_")
 */
class AssetController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add(Request $request)
    {

        $user = $this->getUser();
        // récupération de la carte de visite du candidat connecté
        $visitCardRepo = $this->getDoctrine()->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['id' => $user->getId()]);
        $visitCardId = $visitCard->getId();
        dump($visitCard);
        dump($visitCardId);
        //je récupére les asserts déjà enregistrés
        //$asserts = $visitCard ->getAdditionals();
        $additionalRepo = $this->getDoctrine()->getRepository(Additional::class);
        $asserts = $additionalRepo ->findBy(['visitCard' => $visitCardId, 'typeInfo'=>'assert']);
        dump($asserts);
        $nbAsserts=count($asserts);
        dump($nbAsserts);

        if($nbAsserts <= 5){
            $asset= new Additional();

            $form = $this->createForm(AssetType::class, $asset);

            $form->handleRequest($request);

    
            if ($form->isSubmitted() && $form->isValid()) 
            { //dd($request);
            // ajout des info nécessaire à l'enregistrement
            $asset = $form->getData();
            
            $asset->setVisitCard($visitCard);

            // on sait qu'il s'agit d'un Type info "assert", on l'enregistre par défaut

            $asset ->setTypeInfo('assert');



            $em = $this->getDoctrine()->getManager();

            // enregistrement en bdd ( par un effet "cascade", le website sera enregistré aussi )
            $em->persist($asset);
            $em->flush($asset);

            return $this->redirectToRoute('candidate_profile');
            }
            
        }else {
            $this->addFlash('danger', 'vous avez déjà 5 atouts, vous ne pouvez pas en ajouter d\'avantage');
            return $this->redirectToRoute('candidate_profile');
        }
        

        return $this->render('candidate/profile/asset.html.twig', [
            'form' => $form->createView(),
            'tab_type' => 'Ajouter',
        ]);
        
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit()
    {
        return $this->render('candidate/profile/asset.html.twig', [
            'controller_name' => 'AssetController',
        ]);
    }

    /**
     * @Route("/{id}/supprimer", name="delete")
     */
    public function delete()
    {
        return $this->redirectToRoute('candidate_profile');
    }
}