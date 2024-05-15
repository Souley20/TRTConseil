<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\JobOffer;
use App\Entity\Candidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistration;
use Doctrine\ORM\EntityManagerInterface;

class CandidatureController extends AbstractController
{
    # [Route('/candidature/new/{idCandidate}/{idJobOffer}', name: 'app_candidature', methods: ['GET', 'POST'])]
    public function newCandidature(int $idCandidate, int $idJobOffer, ManagerRegistration $doctrine, EntityManagerInterface $entityManager): Response    
    {
        // Récuperer le candidate
        $emCandidate = $doctrine->getRepository(Candidate::class)->find($idCandidate);

        // Set values in candidature table
        $candidacy = new Candidature();
        $candidacy->setCandidate($emCandidate);
        $candidacy->setJobOffer($emjobOffer);
        $entityManager->persist($candidature);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Vous avez postulé à une annonce. Un consultant doit valider votre demande.'
        );

        return $this->redirectToRoute('app_job_offer_index', [], Response::HTTP_SEE_OTHER);
    }
}
