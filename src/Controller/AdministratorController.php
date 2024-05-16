<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

# [Route('/admin')]
class AdministratorController extends AbstractController
{
    # [Route("/administrator", name="app_administrator")]    
    public function index(): Response
    {
        return $this->render('administrator/index.html.twig');
    }
}
