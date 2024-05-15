<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\JobOffer;
use App\Entity\Recruteur;
use App\Form\RecruteurType;
use App\Repository\RecruteurRepository;
use App\Repository\CandidatureRepository;
use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

# [Route('/recruteur')]
class RecruteurController extends AbstractController
{
    // Homepage recruteur
    # [Route('/recruteur', name: 'app_recruteur')]
    public function index(): Response
    {
        return $this->render('recruteur/index.html.twig');
    }

    // Update recruteur informations page
    # [Route('/{id}/edit', name: 'app_recruteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recruteur $recruteur, RecruteurRepository $recruteurRepository): Response
    {
        $form = $this->createForm(RecruteurType::class, $recruteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recruteurRepository->add($recruteur, true);

            return $this->redirectToRoute('app_recruteur', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recruteur/edit.html.twig', [
            'recruter' => $recruteur,
            'form' => $form,
        ]);
    }

    // Candidatures page
    # [Route('/recruteur-candidatures', name: 'app_recruteur_candidacies')]
    public function showCandidatures(CandidatureRepository $candidatureRepository, JobOfferRepository $jobOfferRepository): Response
    {
        return $this->render('recruteur/recruteur-candidatures.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
            'joboffers' => $jobOfferRepository->findAll(),
        ]);
    }
}
