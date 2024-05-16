<?php

namespace App\Controller;

use App\Entity\candidacy;
use App\Entity\JobOffer;
use App\Entity\Candidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistration;
use Doctrine\ORM\EntityManagerInterface;

class CandidacyController extends AbstractController
{
    # [Route('/candidacy/new/{idCandidate}/{idJobOffer}', name: 'app_candidacy', methods: ['GET', 'POST'])]
    public function newCandidacy(int $idCandidate, int $idJobOffer, ManagerRegistration $doctrine, EntityManagerInterface $entityManager): Response    
    {
        // Récuperer le candidate
        $emCandidate = $doctrine->getRepository(Candidate::class)->find($idCandidate);

        // Set values in candidature table
        $candidacy = new candidacy();
        $candidacy->setCandidate($emCandidate);
        $candidacy->setJobOffer($emjobOffer);
        $entityManager->persist($candidacy);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Vous avez postulé à une annonce. Un consultant doit valider votre demande.'
        );

        return $this->redirectToRoute('app_joboffer_index', [], Response::HTTP_SEE_OTHER);
    }
}
