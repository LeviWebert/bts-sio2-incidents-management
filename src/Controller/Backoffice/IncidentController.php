<?php

namespace App\Controller\Backoffice;

use App\Entity\Incident;
use App\Form\IncidentType;
use App\Repository\IncidentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backoffice/incidents')]
class IncidentController extends AbstractController
{
    #[Route('/', name: 'app_backoffice_incident_index', methods: ['GET'])]
    public function index(IncidentRepository $incidentRepository): Response
    {
        return $this->render('backoffice/incident/index.html.twig', [
            'incidents' => $incidentRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_backoffice_incident_show', methods: ['GET'])]
    public function show(Incident $incident): Response
    {
        return $this->render('backoffice/incident/show.html.twig', [
            'incident' => $incident,
        ]);
    }
}
