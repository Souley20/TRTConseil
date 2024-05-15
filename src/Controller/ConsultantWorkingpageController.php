<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Recruiter;
use App\Entity\JobOffer;
use App\Entity\Candidacy;
use App\Entity\Consultant;
use App\Repository\CandidateRepository;
use App\Repository\RecruiterRepository;
use App\Repository\JobOfferRepository;
use App\Repository\CandidacyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

# [Route('/consultant')]
class ConsultantWorkingpageController extends AbstractController
{
    // homepage consultant
    # [Route('/consultant/workingpage', name: 'app_consultant_workingpage')]
    public function index(): Response
    {
        return $this->render('consultant_workingpage/index.html.twig');
    }

    // Candidates list to validate page
    # [Route('/consultant/workingpagevalidate-candidate', name: 'app_consultant_workingpage_validate_candidate')]
    public function showCandidateToValidate(CandidateRepository $candidateRepository): Response
    {
        return $this->render('consultant_workingpage/validate.html.twig', [
            'candidates' => $candidateRepository->findAll(),
        ]);
    }

    // Candidates validation page
    # [Route('/consultant/workingpagevalidation/{id}', name: 'app_consultant_workingpage_validation')]
    public function validate(int $id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getRepository(Candidate::class);
        $candidate = $em->find($id);
        $id = $candidate->getId();
        $candidate->setIsValid(true);
        $entityManager->flush();

        return $this->redirectToRoute('app_consultant_workingpage_validate_candidate', [
            'Id' => $id
        ]);
    }

    // Recruiters list to validate page
    # [Route('/consultant/workingpagevalidate-recruteur', name: 'app_consultant_workingpage_validate_recruteur')]
    public function showRecruiterToValidate(RecruteurRepository $recruteurRepository): Response
    {
        return $this->render('consultant_workingpage/validate-recruteur.html.twig', [
            'recruteurs' => $recruteurRepository->findAll(),
        ]);
    }

    // Recruteurs validation page
    # [Route('/consultant/workingpagevalidation-recruteur/{id}', name: 'app_consultant_workingpage_validation_recruteur')]
    public function validateRecruiter(int $id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, Recruteur $recruteur): Response
    {
        $em = $doctrine->getRepository(Recruteur::class);
        $recruteur = $em->find($id);
        $id = $recruteur->getId();
        $recruteur->setIsValid(true);
        $entityManager->flush();

        return $this->redirectToRoute('app_consultant_workingpage_validate_recruteur', [
            'Id' => $id
        ]);
    }

    // Joboffers list to validate page
    # [Route('/consultant/workingpagevalidate-joboffer', name: 'app_consultant_workingpage_validate_joboffer')]
    public function showJobOfferToValidate(JobOfferRepository $jobofferRepository): Response
    {
        return $this->render('consultant_workingpage/validate-joboffer.html.twig', [
            'joboffers' => $jobofferRepository->findAll(),
        ]);
    }

    // JobOffers validation page
    # [Route('/consultant/workingpagevalidation-joboffer/{id}/{idConsultant}', name: 'app_consultant_workingpage_validation_joboffer')]
    public function validateJoboffer(int $id, int $idConsultant, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, JobOffer $joboffer): Response
    {
        // Récupérer le consultant
        $emConsultant = $doctrine->getRepository(Consultant::class)->find($idConsultant);

        $em = $doctrine->getRepository(JobOffer::class);
        $joboffer = $em->find($id);
        $id = $joboffer->getId();
        $joboffer->setIsValid(true);
        $joboffer->setConsultant($emConsultant);
        $entityManager->persist($joboffer);
        $entityManager->flush();

        return $this->redirectToRoute('app_consultant_workingpage_validate_joboffer', [], Response::HTTP_SEE_OTHER);
    }

    // Candidatures list to validate page
    # [Route('/consultant/workingpagevalidate-candidature', name: 'app_consultant_workingpage_validate_candidature')]
    public function showCandidatureToValidate(CandidatureRepository $candidatureRepository): Response
    {
        return $this->render('consultant_workingpage/validate-candidature.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
        ]);
    }

    // Candidatures validation page
    # [Route('/consultant/workingpagevalidation-candidature/{id}', name:'app_consultant_workingpage_validation_candidature')]
    public function validateCandidature(
        int $id, 
        EntityManagerInterface $entityManager, 
        ManagerRegistry $doctrine, 
        Candidature $candidature, 
        JobOfferRepository $jobOfferRepository,
        CandidateRepository $candidateRepository,
        MailerInterface $mailer
        ): Response
    {
        $em = $doctrine->getRepository(Candidature::class);
        $candidature = $em->find($id);
        $id = $candidature->getId();
        $candidature->setIsValid(true);
        $entityManager->flush();

        // send mail function to recruiter
        $candidate = $candidateRepository->find($candidature->getCandidate());
        $jobOffer = $jobOfferRepository->find($candidature->getJobOffer());
        $recruteurEmail = $jobOffer->getRecruteur()->getEmail();
        $recruteur = $jobOffer->getRecruteur();
        
        $email = (new Email())
            ->from('brunod.dev@gmail.com')
            ->to($recruteurEmail)
            ->subject('Nouvelle candidature')
            ->html('
                <p>Bonjour '. ucfirst($recruteur->getFirstname()).' '.ucfirst($recruteur->getLastname()).',</p>
                <br>
                <p>Le candidat ' . ucfirst($candidate->getFirstName()) . ' ' . ucfirst($candidate->getLastName()) . ' a postulé à votre annonce "' . $jobOffer->getJobTitle() . '".</p>
                <br>
                <p>Connectez-vous à votre espace recruteur sur le site pour consulter son CV.</p>
                <br>
                <p>Cordialement.</p>
                <p>L\'équipe TRT Conseil.</p>
            ')
            // ->attachFromPath('uploads/'. $candidate->getCV(), 'CV', 'application/pdf')
            // ->html('
            //     <p>Bonjour '. $recruteur->getFirstname().' '.$recruteur->getLastname().',</p>
            //     <br>
            //     <p>Le candidat ' . $candidate->getFirstName() . ' ' . $candidate->getLastName() . ' a postulé à votre annonce "' . $jobOffer->getJobTitle() . '".</p>
            //     <br>
            //     <p>Vous trouverez son CV en pièce jointe.</p>
            // ')
        ;

        $mailer->send($email);

        return $this->redirectToRoute('app_consultant_workingpage_validate_candidature', [
            'Id' => $id,
        ]);
    }
}
