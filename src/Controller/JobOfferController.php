<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Entity\Recruteur;
use App\Form\JobOfferType;
use App\Repository\JobOfferRepository;
use App\Repository\CandidatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class JobOfferController extends AbstractController
{
  // Homepage Joboffer
  # [Route('/joboffer/', name: 'app_joboffer_index', methods: ['GET'])]
    public function index(JobOfferRepository $jobOfferRepository, CandidatureRepository $candidatureRepository): Response
    {   
        return $this->render('job_offer/index.html.twig', [
            'job_offers' => $jobOfferRepository->findAll(),
            'candidacies' => $candidatureRepository->findAll(),
        ]);
    }

    // Create new joboffer page
    # [Route('/recruteur/joboffer/new/{idRecruteur}', name: 'app_joboffer_new', methods: ['GET', 'POST'])]
    public function new(int $idRecruteur, EntityManagerInterface $entityManager,ManagerRegistry $doctrine, Request $request, JobOfferRepository $jobOfferRepository): Response
    {
        // Récupérer le recruteur
        $emRecruteur = $doctrine->getRepository(Recruteur::class)->find($idRecruteur);

        $jobOffer = new JobOffer();
        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

        $jobOffer->setRecruteur($emRecruteur);
        $entityManager->flush();

        if ($form->isSubmitted() && $form->isValid()) {
            $jobOfferRepository->add($jobOffer, true);

            $this->addFlash(
                'success',
                'Votre annonce a bien été enregistée. Un consultant doit la valider avant sa publication.'
            );

            return $this->redirectToRoute('app_joboffer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('joboffer/new.html.twig', [
            'joboffer' => $jobOffer,
            'form' => $form,
        ]);
    }

    // Details joboffer page
    # [Route('/joboffer/{id}', name: 'app_joboffer_show', methods: ['GET'])]
    public function show(JobOffer $jobOffer): Response
    {
        return $this->render('job_offer/show.html.twig', [
            'job_offer' => $jobOffer,
        ]);
    }

    // Update joboffer page
    # [Route('/{id}/edit', name: 'app_joboffer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JobOffer $jobOffer, JobOfferRepository $jobOfferRepository): Response
    {
        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobOfferRepository->add($jobOffer, true);

            return $this->redirectToRoute('app_joboffer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('joboffer/edit.html.twig', [
            'joboffer' => $jobOffer,
            'form' => $form,
        ]);
    }

    // Remove joboffer page
    # [Route('/joboffer/{id}', name: 'app_joboffer_delete', methods: ['POST'])]
    public function delete(Request $request, JobOffer $jobOffer, JobOfferRepository $jobOfferRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jobOffer->getId(), $request->request->get('_token'))) {
            $jobOfferRepository->remove($jobOffer, true);
        }

        return $this->redirectToRoute('app_joboffer_index', [], Response::HTTP_SEE_OTHER);
    }
}
