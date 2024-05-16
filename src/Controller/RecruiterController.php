<?php

namespace App\Controller;

use App\Entity\Candidacy;
use App\Entity\JobOffer;
use App\Entity\Recruiter;
use App\Form\RecruiterType;
use App\Repository\RecruiterRepository;
use App\Repository\CandidacyRepository;
use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

# [Route('/recruiter')]
class RecruiterController extends AbstractController
{
    // Homepage recruiter
    # [Route('/recruiter', name: 'app_recruiter')]
    public function index(): Response
    {
        return $this->render('recruiter/index.html.twig');
    }

    // Update recruiter informations page
    # [Route('/{id}/edit', name: 'app_recruiter_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recruiter $recruiter, RecruiterRepository $recruiterRepository): Response
    {
        $form = $this->createForm(RecruiterType::class, $recruiter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recruiterRepository->add($recruiter, true);

            return $this->redirectToRoute('app_recruiter', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recruiter/edit.html.twig', [
            'recruiter' => $recruiter,
            'form' => $form,
        ]);
    }

    // Candidacies page
    # [Route('/recruiter-candidacies', name: 'app_recruiter_candidacies')]
    public function showCandidacies(CandidacyRepository $candidacyRepository, JobOfferRepository $jobOfferRepository): Response
    {
        return $this->render('recruiter/recruiter-candidacies.html.twig', [
            'candidacies' => $candidacyRepository->findAll(),
            'joboffers' => $jobOfferRepository->findAll(),
        ]);
    }
}
