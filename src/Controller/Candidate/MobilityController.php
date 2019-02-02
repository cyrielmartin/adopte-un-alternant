<?php

namespace App\Controller\Candidate;

use App\Entity\Mobility;
use App\Entity\VisitCard;
use App\Entity\Department;
use App\Form\MobilityType;
use App\Entity\IsCandidate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidat/localisation", name="mobility_")
 */
class MobilityController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $mobility = new Mobility();

        $form = $this->createForm(MobilityType::class, $mobility);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $mobility = $form->getData();
            // je récupère le nom de la ville donnée par le candidat
            $townName = $mobility->getTownName();
            // je remplace tout les accents et caractère particulier potentiel
            $townName = $this->replace_accent($townName);
            // je remplace aussi les espaces par des tirets
            $townName = str_replace(' ', '-', $townName);
            // je prépare mon url
            $apiGeo = 'https://geo.api.gouv.fr/communes?nom='. $townName .'&fields=departement&boost=population';
            // ouverture de connexion à curl
            $curl = curl_init();
            // je prépare ma connexion
            curl_setopt($curl, CURLOPT_URL, $apiGeo);
            // je précise que je veux récupérer le retour ( Deuxième paramètre : 1 )
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            // j'execute ma connexion et récupère le json
            $jsonResponse = curl_exec($curl);
            // je ferme ma connexion 
            curl_close($curl);
            // je décode ce que j'ai récupéré
            $response = json_decode($jsonResponse, true);

            if (empty($response)) 
            {
                $this->addFlash('danger', 'Ville introuvable ou inexistante');
                return $this->redirectToRoute('mobility_add');
            }
            if(count($response) > 1)
            {
                $this->addFlash('danger', 'Correspondance avec plusieurs villes, merci d\'écrire le nom complet');
                return $this->redirectToRoute('mobility_add');
            }

            $townName = $response[0]['nom'];
            
            $mobilityRepo = $em->getRepository(Mobility::class);
            $mobilityExist = $mobilityRepo->findOneBy(['townName' => $townName]);

            if(!empty($mobilityExist))
            {
                $mobility = $mobilityExist;
            }
            else
            {
                $mobility->setTownName($townName);
                $dptCode = $response[0]['departement']['code'];
                
                $dptRepo = $em->getRepository(Department::class);
                $department = $dptRepo->findOneBy(['code' => $dptCode]);
                
                $mobility->setDepartment($department);
                $em->persist($mobility);
            }

            // je récupère le user
            $user = $this->getUser();
            // je récupère sa fiche candidat
            $candidateRepo = $em->getRepository(IsCandidate::class);
            $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);
            // je récupère la carte de visite du candidat
            $visitCardRepo = $em->getRepository(VisitCard::class);
            $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);
            
            $visitCard->addMobility($mobility);
            $em->persist($visitCard);
            $em->flush();

            return $this->redirectToRoute('candidate_profile');
        }
        return $this->render('candidate/profile/mobility.html.twig', [
            'tab_type' => 'Ajouter',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit()
    {
        return $this->render('candidate/profile/mobility.html.twig', [
            'tab_type' => 'Modifier',
        ]);
    }

    function replace_accent($str)
    {
        // transformer les caractères accentués en entités HTML
        $str = htmlentities($str, ENT_NOQUOTES, 'utf-8');
     
        // remplacer les entités HTML pour avoir juste le premier caractères non accentués
        // Exemple : "&ecute;" => "e", "&Ecute;" => "E", "à" => "a" ...
        $str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);
     
        // Remplacer les ligatures tel que : , Æ ...
        // Exemple "œ" => "oe"
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        // Supprimer tout le reste
        $str = preg_replace('#&[^;]+;#', '', $str);
     
        return $str;
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
        // je récupère sa carte de visite 
        $visitCardRepo = $this->getDoctrine()->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);
        // je récupère la mobilité via sont id
        $mobilityRepo = $this->getDoctrine()->getRepository(Mobility::class);
        $mobility = $mobilityRepo->find($id);
        
        // si cette mobilité existe
        if(!empty($mobility))
        {
            // je supprime la relation avec celle-ci de la carte de visite du candidat
            $visitCard->removeMobility($mobility);

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'La ville a bien été supprimée.');
        }
        // si la mobilité n'existe pas
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue lors de la suppression.');
        }
        
        return $this->redirectToRoute('candidate_profile');
    }
}