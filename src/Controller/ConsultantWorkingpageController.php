<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsultantWorkingpageController extends AbstractController
{
    /**
     * @Route("/consultant/workingpage", name="app_consultant_workingpage")
     */
    public function index(): Response
    {
        return $this->render('consultant_workingpage/index.html.twig', [
            'controller_name' => 'ConsultantWorkingpageController',
        ]);
    }
}
