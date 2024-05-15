<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Form\CandidateType;
use App\Repository\CandidatureRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

# [Route('/candidate')
class CandidateController extends AbstractController
{
      // HomePage candidat
     # [Route("/candidate", name="app_candidate")]   
    public function index(): Response
    {
        return $this->render('candidate/index.html.twig');
    }

    // Update candidate informations page
    # [Route('/{id}/edit', name: 'app_candidate_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, Candidate $candidate, CandidateRepository $candidateRepository, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // Get form
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidate = $form->getData();
            $entityManager->persist($candidate);
            $entityManager->flush();

            /** @var UploadedFile $cv */
            $cvFile = $form->get('cv')->getData();
            
            // this condition is needed because the 'cv' field is not required
            // so the file must be processed only when a file is uploaded
            if ($cvFile) {
                $originalFilename = pathinfo($cvFile->getClientOriginalName(), PATHINFO_FILENAME);
                  // this is needed to safely include the file name as part of the URL
                  $safeFilename = $slugger->slug($originalFilename);
                  $newFilename = $safeFilename.'-'.uniqid().'.'.$cvFile->guessExtension();
                
                // Move the file to the directory where cv are stored
                try {
                    $cvFile->move(
                        $this->getParameter('cv_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', $e->getMessage());
                }
 
                // updates the 'cvname' property to store the pdf file name
                $candidate->setCv($newFilename);
                $entityManager->persist($candidate);
                $entityManager->flush();
            }
            

            return $this->redirectToRoute('app_candidate', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidate/edit.html.twig', [
            'candidate' => $candidate,
            'form' => $form,
        ]);
    }

    // Candidatures page
    # [Route('/candidate-candidatures', name: 'app_candidate_candidatures')]
    public function showCandidateCandidatures(CandidatureRepository $candidatureRepository): Response
    {
        return $this->render('candidate/candidate-candidatures.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
        ]);
    }
}
