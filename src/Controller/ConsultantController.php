<?php

namespace App\Controller;

use App\Entity\Consultant;
use App\Form\ConsultantType;
use App\Repository\ConsultantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

# [Route('/admin/consultant')]
class ConsultantController extends AbstractController
{ 
    # [Route('/', name: 'app_create_consultant_index', methods: ['GET'])]
    public function index(ConsultantRepository $consultantRepository): Response
    {
        return $this->render('consultant/index.html.twig', [
            'consultants' => $consultantRepository->findAll(),
        ]);
    }

    # [Route('/new', name: 'app_create_consultant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConsultantRepository $consultantRepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $consultant = new Consultant();
        $form = $this->createForm(ConsultantType::class, $consultant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $consultantRepository->add($consultant, true);
 
            // encode the password
            $consultant->setPassword(
            $userPasswordHasher->hashPassword(
                    $consultant,
                    $form->get('password')->getData()
                )
            );

            // Set the role
            $consultant->setRoles(['ROLE_CONSULTANT']);
            $entityManager->persist($consultant);
            $entityManager->flush();

            return $this->redirectToRoute('app_create_consultant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consultant/new.html.twig', [
            'consultant' => $consultant,
            'form' => $form,
        ]);
    }

    # [Route('/{id}', name: 'app_create_consultant_show', methods: ['GET'])]
    public function show(Consultant $consultant): Response
    {
        return $this->render('consultant/show.html.twig', [
            'consultant' => $consultant,
        ]);
    }

    # [Route('/{id}/edit', name: 'app_create_consultant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Consultant $consultant, ConsultantRepository $consultantRepository): Response
    {
        $form = $this->createForm(ConsultantType::class, $consultant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $consultantRepository->add($consultant, true);

            return $this->redirectToRoute('app_create_consultant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consultant/edit.html.twig', [
            'consultant' => $consultant,
            'form' => $form,
        ]);
    }

    # [Route('/{id}', name: 'app_create_consultant_delete', methods: ['POST'])]
    public function delete(Request $request, Consultant $consultant, ConsultantRepository $consultantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consultant->getId(), $request->request->get('_token'))) {
            $consultantRepository->remove($consultant, true);
        }

        return $this->redirectToRoute('app_create_consultant_index', [], Response::HTTP_SEE_OTHER);
    }
}
