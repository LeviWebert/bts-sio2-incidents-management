<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_welcome')]
    public function welcome(): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController::welcome',
        ]);
    }

    #[Route('/report-incident', name: 'app_report_incident')]
    public function reportIncident(): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController::reportIncident',
        ]);
    }
}
