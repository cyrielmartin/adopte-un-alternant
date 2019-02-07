<?php

namespace App\Controller\Toggle;

use App\Entity\VisitCard;
use App\Entity\IsCandidate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/toggle/status", name="toogle_")
 */
class ToggleController extends AbstractController
{
    /**
     * @Route("/apprenticeship", name="apprenticeship")
     */
    public function apprenticeship(Request $request, EntityManagerInterface $em)
    {
        // une personne non connecté et qui n'est pas candidat ne peux pas accéder à cette méthode
        $this->denyAccessUnlessGranted('ROLE_CANDIDATE', null, 'Unable to access this page!');
        
        $user = $this->getUser();

        // je récupère sa fiche candidat
        $candidateRepo = $this->getDoctrine()->getRepository(IsCandidate::class);
        $candidate = $candidateRepo->findOneBy(['user' => $user->getId()]);

        // récupération de la carte de visite du candidat connecté
        $visitCardRepo = $em->getRepository(VisitCard::class);
        $visitCard = $visitCardRepo->findOneBy(['isCandidate' => $candidate->getId()]);

        // je récupére le status
        $status = $request->query->get('status');
        $response = 'fail';

        // si le status est à 0
        if($status === '0')
        {
            // je met à jour mon status de adopted
            $visitCard->setAdopted(0);
            $em->flush();
            $response = 'success';
        }
        // si le status est à 1
        elseif($status === '1')
        {
            // je met à jour mon status adopted
            $visitCard->setAdopted(1);
            $em->flush();
            $response = 'success';
        }
        
        // je retourne success ou fail
        return new JsonResponse($response);
    }
}